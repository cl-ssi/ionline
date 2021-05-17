<?php

namespace App\Http\Controllers;

use App\Mail\SignedDocument;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Generator;

/* No se si son necesarias, las puse para el try catch */

use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Storage;
use Str;

class FirmaDigitalController extends Controller
{
    const modoDesatendidoTest = 0;
    const modoAtendidoTest = 1;
    const modoAtendidoProduccion = 2;

    /**
     * Función que recibe pdf a firmar desde url o archivo, lo firma llamando a signPdfApi y guarda NUEVO registro
     * SignaturesFile.
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function signPdf(Request $request)
    {
        if ($request->has('file_path')) {
            $filePath = $request->file_path;

            if (Storage::disk('local')->exists($filePath)) {
                $pdfbase64 = base64_encode(file_get_contents(Storage::disk('local')->path($filePath)));
                $checksum_pdf = md5_file(Storage::disk('local')->path($filePath));
            } else
                return 'no existe archivo';
        } else {
            $route = $request->route;

            $req = Request::create($route,
                'GET',
                [],
                [],
                [],
                $_SERVER);

            $res = app()->handle($req);
            $responseBody = $res->getContent();

            $pdfbase64 = base64_encode($responseBody);
            $checksum_pdf = md5($responseBody);

//            Log::info($checksum_pdf);
//            dd($responseBody);
//            header('Content-Type: application/pdf');
//            echo base64_decode($pdfbase64);
        }

        $modo = self::modoAtendidoProduccion;
        $otp = $request->otp;
        $modelId = $request->model_id;
        $signatureType = 'firmante';
        $callbackRoute = $request->callback_route;

        $id = DB::select("SHOW TABLE STATUS LIKE 'doc_signatures_files'");
        $docId = $id[0]->Auto_increment;
        $verificationCode = Str::random(6);

        $responseArray = $this->signPdfApi($pdfbase64, $checksum_pdf, $modo, $otp, $signatureType, $docId, $verificationCode);

        if (!$responseArray['statusOk']) {
            return redirect()->route($callbackRoute, ['message' => "Ocurrió un problema al firmar el documento: {$responseArray['errorMsg']}",
                'modelId' => $modelId]);
        }

        $signaturesFile = SignaturesFile::create();
//        $signaturesFile->signed_file = $responseArray['content'];
        $signaturesFile->md5_file = $checksum_pdf;
        $signaturesFile->signer_id = Auth::id();
        $signaturesFile->verification_code = $verificationCode;
        $signaturesFile->save();

        //Se guarda en gcs
        $filePath = 'ionline/signatures/signed/' . $signaturesFile->id . '.pdf';
        $signaturesFile->update(['signed_file' => $filePath]);
        Storage::disk('gcs')->put($filePath, base64_decode($responseArray['content']));

        return redirect()->route($callbackRoute, ['message' => "El documento $signaturesFile->id se ha firmado correctamente.",
            'modelId' => $modelId,
            'signaturesFile' => $signaturesFile->id]);
    }

    /**
     * Función para firmar en modulo de solicitud de firmas, llamando a signPdfApi
     * @param Request $request
     * @param SignaturesFlow $signaturesFlow
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function signPdfFlow(Request $request, SignaturesFlow $signaturesFlow)
    {
//        if ($signaturesFlow->signaturesFile->signed_file)
//            $pdfbase64 = $signaturesFlow->signaturesFile->signed_file;
//         else
//            $pdfbase64 = $signaturesFlow->signaturesFile->file;

        if ($signaturesFlow->signaturesFile->signed_file)
            $pdfbase64 = base64_encode(Storage::disk('gcs')->get($signaturesFlow->signaturesFile->signed_file));
        else
            $pdfbase64 = base64_encode(Storage::disk('gcs')->get($signaturesFlow->signaturesFile->file));

        $checksum_pdf = $signaturesFlow->signaturesFile->md5_file;
        $type = $signaturesFlow->type;
        $visatorAsSignature = $signaturesFlow->signature->visatorAsSignature;
        $otp = $request->otp;
        $modo = self::modoAtendidoProduccion;
        $verificationCode = Str::random(6);
        $id = DB::select("SHOW TABLE STATUS LIKE 'doc_signatures_files'");
        $docId = $id[0]->Auto_increment;

        $ct_firmas_visator = null;
        $ct_posicion_firmas = null;
        if ($type === 'visador') {
            $ct_firmas_visator = $signaturesFlow->signaturesFile->signaturesFlows->where('type', 'visador')->count();
            $ct_posicion_firmas = $signaturesFlow->sign_position;
        }

        $responseArray = $this->signPdfApi($pdfbase64, $checksum_pdf, $modo, $otp, $type, $docId, $verificationCode,
            $ct_firmas_visator, $ct_posicion_firmas, $visatorAsSignature);

        if (!$responseArray['statusOk']) {
            session()->flash('warning', "Ocurrió un problema al firmar el documento: {$responseArray['errorMsg']}");
            return redirect()->route('documents.signatures.index', ['pendientes']);
        }

        $signaturesFlow->status = 1;
        $signaturesFlow->signature_date = now();
        $signaturesFlow->save();

//        $signaturesFlow->signaturesFile->signed_file = $responseArray['content'];

        if ($signaturesFlow->signaturesFile->signed_file) {
            $filePath = $signaturesFlow->signaturesFile->signed_file;
            Storage::disk('gcs')->put($filePath, base64_decode($responseArray['content']));
        }else {
            $filePath = 'ionline/signatures/signed/' . $signaturesFlow->signaturesFile->id . '.pdf';
            $signaturesFlow->signaturesFile->signed_file = $filePath;
            Storage::disk('gcs')->put($filePath, base64_decode($responseArray['content']));
        }

//        $signaturesFlow->signaturesFile->signed_file = $responseArray['content'];

        if ($type === 'firmante') $signaturesFlow->signaturesFile->verification_code = $verificationCode;
        $signaturesFlow->signaturesFile->save();

        $signaturesFlow = SignaturesFlow::find($signaturesFlow->id);

        //Si ya firmaron todos se envía por correo a destinatarios del doc
        if ($signaturesFlow->signaturesFile->hasAllFlowsSigned) {
            $allEmails = $signaturesFlow->signature->recipients . ',' . $signaturesFlow->signature->distribution;

            preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $allEmails, $emails);
            Mail::to($emails[0])
                ->send(new SignedDocument($signaturesFlow->signature));
        }

        session()->flash('info', "El documento {$signaturesFlow->signature->id} se ha firmado correctamente.");
        return redirect()->route('documents.signatures.index', ['pendientes']);
    }

    /**
     * Llamada a la API que firma documento
     * @param string $pdfbase64
     * @param string $checksum_pdf
     * @param $modo
     * @param string $otp
     * @param string $signatureType
     * @param int $docId
     * @param string $verificationCode
     * @param int|null $ct_firmas_visator Cantidad de firmas visador
     * @param int|null $posicion_firma
     * @param bool|null $visatorAsSignature Si es true, el template de visador se visualizaran igual a las de las firmas
     * @return array
     */
    public function signPdfApi(string $pdfbase64, string $checksum_pdf, $modo, string $otp, string $signatureType,
                               int $docId, string $verificationCode, int $ct_firmas_visator = null, int $posicion_firma = null,
                               bool $visatorAsSignature = null): array
    {

//        dd($pdfbase64, $checksum_pdf, $modo, $otp, $signatureType);
        /* Confección del cuadro imagen de la firma */
        $font_light = public_path('fonts/verdana-italic.ttf');
        $font_bold = public_path('fonts/verdana-bold-2.ttf');
        $font_regular = public_path('fonts/Verdana.ttf');

        $marginTop = 1;
        $xAxis = 5;
        $yPading = 16;
        $fontSize = 10;

        $actualDate = now()->format('d-m-Y H:i:s');
        $fullName = Auth::user()->full_name;

        if ($signatureType === 'firmante' || $visatorAsSignature === true) {
            $im = @imagecreate(480, 80) or die("Cannot Initialize new GD image stream");
            $background_color = imagecolorallocate($im, 204, 204, 204);
            $white = imagecolorallocate($im, 255, 255, 255);
            imagefilledrectangle($im, 1, 1, 398, 78, $white);
            $text_color = imagecolorallocate($im, 0, 0, 0);

            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 1 + $marginTop,
                $text_color, $font_light, "Firmado digitalmente de acuerdo con la ley Nº 19.799");
            imagettftext($im, $fontSize + 1, 0, $xAxis, $yPading * 2 + $marginTop + 2,
                $text_color, $font_bold, $fullName);
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 3 + $marginTop + 3,
                $text_color, $font_regular, env('APP_SS'));
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 4 + $marginTop + 4,
                $text_color, $font_regular, $actualDate . ($signatureType === 'firmante' ? "- ID: $docId - Código: $verificationCode" : ''));
        } else {
            $im = @imagecreate(400, 40) or die("Cannot Initialize new GD image stream");
//            $background_color = imagecolorallocate($im, 204, 204, 204);
            $white = imagecolorallocate($im, 255, 255, 255);
            imagefilledrectangle($im, 0, 0, 400, 40, $white);
            $text_color = imagecolorallocate($im, 0, 0, 0);
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 1 + $marginTop,
                $text_color, $font_light, Str::upper(Auth::user()->initials) . ' - ' . Str::upper(Auth::user()->organizationalUnit->initials));
        }

        $firma_gob = imagecreatefrompng(public_path('images/firma_gobierno_80.png'));
        //( $dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct )
        imagecopymerge($im, $firma_gob, 400, 0, 0, 0, 80, 84, 100);

        /* Obtener Imagen de firma en variable $firma */
        ob_start();
        imagepng($im);
        $firma = base64_encode(ob_get_clean());
        imagedestroy($im);
        //die();

        /* Fin cuadro de firma */

        if ($modo == self::modoDesatendidoTest) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';

            $run = 22222222;  // $run = 22222222;
//            $otp = 227083;

            $purpose = 'Desatendido'; // $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';

            /* $pdfbase64 = base64_encode(file_get_contents(public_path('samples/sample3.pdf'))); */
        } elseif ($modo == self::modoAtendidoTest) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';
            $run = 11111111;
            $otp = $otp;

            $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';
        } elseif ($modo == self::modoAtendidoProduccion) {
            $url = env('FIRMA_URL');
            $api_token = env('FIRMA_API_TOKEN');
            $secret = env('FIRMA_SECRET');
            $otp = $otp;
            $run = Auth::id();
//            $run = 16351236;

            $purpose = 'Propósito General';
            $entity = 'Servicio de Salud Iquique';
        } else {
            session()->flash('warning', 'Modo de firma no seleccionado');
            return redirect()->route('documents.signatures.index', ['pendientes']);
        }

        /* Confección firma en JWT */
        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $run
        ];

        $jwt = JWT::encode($payload, $secret);
        // die($jwt);

        if ($signatureType == 'visador') {
//            $ct_firmas = $signaturesFlow->signature->signaturesFlows->where('type', 'visador')->count();
//            $pocision_firma = $signaturesFlow->sign_position;

            if ($visatorAsSignature === true) {
                $padding = 50;
                $alto = 55;
            } else {
                $padding = 25;
                $alto = 26;
            }
            $coordenada_x = 65;
            $coordenada_y = 50 + $padding * $ct_firmas_visator - ($posicion_firma * $padding);
            $ancho = 170 * 1.4;
        } else if ($signatureType == 'firmante') {
            $coordenada_x = 270;
            $coordenada_y = 65;
            $ancho = 200 * 1.4;
            $alto = 55;
        }

        $data = [
            'api_token_key' => $api_token,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $pdfbase64,
                    'description' => 'str',
                    'checksum' => $checksum_pdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"1\">
                                        <llx>" . $coordenada_x . "</llx>
                                        <lly>" . $coordenada_y . "</lly>
                                        <urx>" . ($coordenada_x + $ancho) . "</urx>
                                        <ury>" . ($coordenada_y + $alto) . "</ury>
                                        <page>LAST</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$firma</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

//        dd(json_encode($data, JSON_PRETTY_PRINT));

        // <llx> Coordenada x de la esquina inferior izquierda de la imagen.
        // <lly> Coordenada y de la esquina inferior izquierda de la imagen.
        // <urx> Coordenada x de la esquina superior derecha de la imagen.
        // <ury> Coordenada y de la esquina superior derecha de la imagen.

        try {
            if ($modo = self::modoAtendidoTest or $modo = self::modoAtendidoProduccion) {
                $response = Http::withHeaders(['otp' => $otp])->post($url, $data);
            } else {
                $response = Http::post($url, $data);
            }
        } catch (ConnectException | RequestException | Exception $e) {
            var_dump($e);
            exit();
        }
        $json = $response->json();

//        dd($json);

        if (array_key_exists('error', $json)) {
            return ['statusOk' => false,
                'content' => '',
                'errorMsg' => $json['error'],
            ];
        }

        if (!array_key_exists('content', $json['files'][0])) {
            if (array_key_exists('error', $json)) {
                return ['statusOk' => false,
                    'content' => '',
                    'errorMsg' => $json['error'],
                ];
            } else {
                return ['statusOk' => false,
                    'content' => '',
                    'errorMsg' => $json['files'][0]['status'],
                ];
            }

        }

        return ['statusOk' => true,
            'content' => $json['files'][0]['content'],
            'errorMsg' => '',
        ];
    }

    public function test($otp) {
        $pdf            = 'samples/original.pdf';
        $pdfbase64      = base64_encode(file_get_contents(public_path($pdf)));
        $checksum_pdf   = md5_file(public_path($pdf));
        $signatureType  = 'firmante';
        $docId          = 1;
        $verificationCode = 'asaasf';


        $actualDate = now()->format('d-m-Y H:i:s');
        $fullName = Auth::user()->full_name;


        /* Confección del cuadro imagen de la firma */
        $font_light     = public_path('fonts/verdana-italic.ttf');
        $font_bold      = public_path('fonts/verdana-bold-2.ttf');
        $font_regular   = public_path('fonts/Verdana.ttf');

        $marginTop  = 1;
        $xAxis      = 5;
        $yPading    = 16;
        $fontSize   = 10;

        if ($signatureType === 'firmante' || $visatorAsSignature === true) {
            $im = @imagecreate(480, 80) or die("Cannot Initialize new GD image stream");
            $background_color = imagecolorallocate($im, 204, 204, 204);
            $white = imagecolorallocate($im, 255, 255, 255);
            imagefilledrectangle($im, 1, 1, 398, 78, $white);
            $text_color = imagecolorallocate($im, 0, 0, 0);

            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 1 + $marginTop,
                $text_color, $font_light, "Firmado digitalmente de acuerdo con la ley Nº 19.799");
            imagettftext($im, $fontSize + 1, 0, $xAxis, $yPading * 2 + $marginTop + 2,
                $text_color, $font_bold, $fullName);
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 3 + $marginTop + 3,
                $text_color, $font_regular, env('APP_SS'));
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 4 + $marginTop + 4,
                $text_color, $font_regular, $actualDate . ($signatureType === 'firmante' ? "- ID: $docId - Código: $verificationCode" : ''));
        } else {
            $im = @imagecreate(400, 40) or die("Cannot Initialize new GD image stream");
            // $background_color = imagecolorallocate($im, 204, 204, 204);
            $white = imagecolorallocate($im, 255, 255, 255);
            imagefilledrectangle($im, 0, 0, 400, 40, $white);
            $text_color = imagecolorallocate($im, 0, 0, 0);
            imagettftext($im, $fontSize, 0, $xAxis, $yPading * 1 + $marginTop,
                $text_color, $font_light, Str::upper(Auth::user()->initials) . ' - ' . Str::upper(Auth::user()->organizationalUnit->initials));
        }

        $firma_gob = imagecreatefrompng(public_path('images/firma_gobierno_80.png'));
        //imagecopyresized($thumb, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
        //( $dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct )
        imagecopymerge($im, $firma_gob, 400, 0, 0, 0, 80, 84, 100);

        /* Obtener Imagen de firma en variable $firma */
        ob_start();
        imagepng($im);
        $firma = base64_encode(ob_get_clean());
        imagedestroy($im);

        $url        = env('FIRMA_URL');
        $api_token  = env('FIRMA_API_TOKEN');
        $secret     = env('FIRMA_SECRET');
        $otp        = $otp;
        $run        = Auth::id();

        $purpose    = 'Propósito General';
        $entity     = 'Servicio de Salud Iquique';

        /* Confección firma en JWT */
        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $run
        ];

        $jwt = JWT::encode($payload, $secret);
        //die($jwt);

        if ($signatureType == 'visador') {
            // $ct_firmas = $signaturesFlow->signature->signaturesFlows->where('type', 'visador')->count();
            // $pocision_firma = $signaturesFlow->sign_position;

            if ($visatorAsSignature === true) {
                $padding = 50;
                $alto = 55;
            } else {
                $padding = 25;
                $alto = 26;
            }
            $coordenada_x = 65;
            $coordenada_y = 50 + $padding * $ct_firmas_visator - ($posicion_firma * $padding);
            $ancho = 170 * 1.4;
        } else if ($signatureType == 'firmante') {
            $coordenada_x = 270;
            $coordenada_y = 65;
            $ancho = 200 * 1.4;
            $alto = 55;
        }

        //header("Content-type: image/png");
        //echo base64_decode($firma);

        $data = [
            'api_token_key' => $api_token,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => 'JVBERi0xLjMNCiXi48/TDQoNCjEgMCBvYmoNCjw8DQovVHlwZSAvQ2F0YWxvZw0KL091dGxpbmVzIDIgMCBSDQovUGFnZXMgMyAwIFINCj4+DQplbmRvYmoNCg0KMiAwIG9iag0KPDwNCi9UeXBlIC9PdXRsaW5lcw0KL0NvdW50IDANCj4+DQplbmRvYmoNCg0KMyAwIG9iag0KPDwNCi9UeXBlIC9QYWdlcw0KL0NvdW50IDINCi9LaWRzIFsgNCAwIFIgNiAwIFIgXSANCj4+DQplbmRvYmoNCg0KNCAwIG9iag0KPDwNCi9UeXBlIC9QYWdlDQovUGFyZW50IDMgMCBSDQovUmVzb3VyY2VzIDw8DQovRm9udCA8PA0KL0YxIDkgMCBSIA0KPj4NCi9Qcm9jU2V0IDggMCBSDQo+Pg0KL01lZGlhQm94IFswIDAgNjEyLjAwMDAgNzkyLjAwMDBdDQovQ29udGVudHMgNSAwIFINCj4+DQplbmRvYmoNCg0KNSAwIG9iag0KPDwgL0xlbmd0aCAxMDc0ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBBIFNpbXBsZSBQREYgRmlsZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIFRoaXMgaXMgYSBzbWFsbCBkZW1vbnN0cmF0aW9uIC5wZGYgZmlsZSAtICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjY0LjcwNDAgVGQNCigganVzdCBmb3IgdXNlIGluIHRoZSBWaXJ0dWFsIE1lY2hhbmljcyB0dXRvcmlhbHMuIE1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NTIuNzUyMCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDYyOC44NDgwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjE2Ljg5NjAgVGQNCiggdGV4dC4gQW5kIG1vcmUgdGV4dC4gQm9yaW5nLCB6enp6ei4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNjA0Ljk0NDAgVGQNCiggbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDU5Mi45OTIwIFRkDQooIEFuZCBtb3JlIHRleHQuIEFuZCBtb3JlIHRleHQuICkgVGoNCkVUDQpCVA0KL0YxIDAwMTAgVGYNCjY5LjI1MDAgNTY5LjA4ODAgVGQNCiggQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA1NTcuMTM2MCBUZA0KKCB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBFdmVuIG1vcmUuIENvbnRpbnVlZCBvbiBwYWdlIDIgLi4uKSBUag0KRVQNCmVuZHN0cmVhbQ0KZW5kb2JqDQoNCjYgMCBvYmoNCjw8DQovVHlwZSAvUGFnZQ0KL1BhcmVudCAzIDAgUg0KL1Jlc291cmNlcyA8PA0KL0ZvbnQgPDwNCi9GMSA5IDAgUiANCj4+DQovUHJvY1NldCA4IDAgUg0KPj4NCi9NZWRpYUJveCBbMCAwIDYxMi4wMDAwIDc5Mi4wMDAwXQ0KL0NvbnRlbnRzIDcgMCBSDQo+Pg0KZW5kb2JqDQoNCjcgMCBvYmoNCjw8IC9MZW5ndGggNjc2ID4+DQpzdHJlYW0NCjIgSg0KQlQNCjAgMCAwIHJnDQovRjEgMDAyNyBUZg0KNTcuMzc1MCA3MjIuMjgwMCBUZA0KKCBTaW1wbGUgUERGIEZpbGUgMiApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY4OC42MDgwIFRkDQooIC4uLmNvbnRpbnVlZCBmcm9tIHBhZ2UgMS4gWWV0IG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NzYuNjU2MCBUZA0KKCBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSB0ZXh0LiBBbmQgbW9yZSApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY2NC43MDQwIFRkDQooIHRleHQuIE9oLCBob3cgYm9yaW5nIHR5cGluZyB0aGlzIHN0dWZmLiBCdXQgbm90IGFzIGJvcmluZyBhcyB3YXRjaGluZyApIFRqDQpFVA0KQlQNCi9GMSAwMDEwIFRmDQo2OS4yNTAwIDY1Mi43NTIwIFRkDQooIHBhaW50IGRyeS4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gQW5kIG1vcmUgdGV4dC4gKSBUag0KRVQNCkJUDQovRjEgMDAxMCBUZg0KNjkuMjUwMCA2NDAuODAwMCBUZA0KKCBCb3JpbmcuICBNb3JlLCBhIGxpdHRsZSBtb3JlIHRleHQuIFRoZSBlbmQsIGFuZCBqdXN0IGFzIHdlbGwuICkgVGoNCkVUDQplbmRzdHJlYW0NCmVuZG9iag0KDQo4IDAgb2JqDQpbL1BERiAvVGV4dF0NCmVuZG9iag0KDQo5IDAgb2JqDQo8PA0KL1R5cGUgL0ZvbnQNCi9TdWJ0eXBlIC9UeXBlMQ0KL05hbWUgL0YxDQovQmFzZUZvbnQgL0hlbHZldGljYQ0KL0VuY29kaW5nIC9XaW5BbnNpRW5jb2RpbmcNCj4+DQplbmRvYmoNCg0KMTAgMCBvYmoNCjw8DQovQ3JlYXRvciAoUmF2ZSBcKGh0dHA6Ly93d3cubmV2cm9uYS5jb20vcmF2ZVwpKQ0KL1Byb2R1Y2VyIChOZXZyb25hIERlc2lnbnMpDQovQ3JlYXRpb25EYXRlIChEOjIwMDYwMzAxMDcyODI2KQ0KPj4NCmVuZG9iag0KDQp4cmVmDQowIDExDQowMDAwMDAwMDAwIDY1NTM1IGYNCjAwMDAwMDAwMTkgMDAwMDAgbg0KMDAwMDAwMDA5MyAwMDAwMCBuDQowMDAwMDAwMTQ3IDAwMDAwIG4NCjAwMDAwMDAyMjIgMDAwMDAgbg0KMDAwMDAwMDM5MCAwMDAwMCBuDQowMDAwMDAxNTIyIDAwMDAwIG4NCjAwMDAwMDE2OTAgMDAwMDAgbg0KMDAwMDAwMjQyMyAwMDAwMCBuDQowMDAwMDAyNDU2IDAwMDAwIG4NCjAwMDAwMDI1NzQgMDAwMDAgbg0KDQp0cmFpbGVyDQo8PA0KL1NpemUgMTENCi9Sb290IDEgMCBSDQovSW5mbyAxMCAwIFINCj4+DQoNCnN0YXJ0eHJlZg0KMjcxNA0KJSVFT0YNCg==',
                    'description' => 'str',
                    'checksum' => $checksum_pdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"1\">
                                        <llx>" . $coordenada_x . "</llx>
                                        <lly>" . $coordenada_y . "</lly>
                                        <urx>" . ($coordenada_x + $ancho) . "</urx>
                                        <ury>" . ($coordenada_y + $alto) . "</ury>
                                        <page>LAST</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$firma</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

        //print_r($data);
        //die();

        $response = Http::withHeaders(['otp' => $otp])->post($url, $data);
        $json = $response->json();
        //dd($json);
//        $json['files'][0]['content'];

        header('Content-Type: application/pdf');
        echo base64_decode($json['files'][0]['content']);

        die();

    }

}

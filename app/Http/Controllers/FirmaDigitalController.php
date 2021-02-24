<?php

namespace App\Http\Controllers;

use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use SimpleSoftwareIO\QrCode\Generator;


/* No se si son necesarias, las puse para el try catch */
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;


class FirmaDigitalController extends Controller
{
    const modoDesatendidoTest = 0;
    const modoAtendidoTest = 1;
    const modoAtendidoProduccion = 2;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param SignaturesFlow $signaturesFlow
     * @return RedirectResponse
     */
    public function signPdf(Request $request, SignaturesFlow $signaturesFlow)
    {
//        dd($request->otp);
//        dd($signaturesFlow);
        // echo '<pre>'; /* Debug Para mostrar la imágen de la firma */
        //header("Content-Type: image/png; charset=UTF-8");

        /* Setear Variables */
        $modo           = self::modoAtendidoProduccion; /* Si es test se usará un run o otp de prueba */
        $otp            = '';
//        $pocision_firma = 1; /* Sólo para tipo "vb" */
//        $ct_firmas      = 4; /* Sólo para tipo "vb" */

        /* Fin seteo de variable */

        if ($signaturesFlow->signaturesFile->signed_file) {
            $pdfbase64      = $signaturesFlow->signaturesFile->signed_file;
        }else{
            $pdfbase64 = $signaturesFlow->signaturesFile->file;
        }

        $checksum_pdf   = $signaturesFlow->signaturesFile->md5_file;

        /* Confección del cuadro imagen de la firma */
        $font_light   = public_path('fonts/verdana-italic.ttf');
        $font_bold    = public_path('fonts/verdana-bold-2.ttf');
        $font_regular = public_path('fonts/Verdana.ttf');

        $im = @imagecreate(400, 60) or die("Cannot Initialize new GD image stream");

        $background_color = imagecolorallocate($im, 204, 204, 204);
        $white            = imagecolorallocate($im, 255, 255, 255);

        //imagefilledrectangle($image,int $x1,int $y1,int $x2,int $y2,int $color).
        imagefilledrectangle(   $im,       1,      1,     398,     58,    $white);

        $text_color = imagecolorallocate($im, 0, 0, 0);

        $marginTop  = 1;
        $xAxis      = 5;
        $yPading    = 16;
        $fontSize   = 10;

        /* email=alvaro.torres@redsalud.gob.cl
         * cn=Álvaro Raymundo Edgardo Torres Fuchslocher
         * serialNumber=15287582-7
         * title=Profesional Sidra
         * o=Ministerio de Salud
         * cn=Autoridad Certificadora del Estado de Chile
         */

        $actualDate = now();
        $fullName = \Auth::user()->full_name;
        $email = \Auth::user()->email;

        imagettftext($im, $fontSize,   0, $xAxis, $yPading * 1 + $marginTop,
            $text_color, $font_light,  "Firmado digitalmente el $actualDate por:");
        imagettftext($im, $fontSize+1, 0, $xAxis, $yPading * 2 + $marginTop + 2,
            $text_color, $font_bold, $fullName);
        imagettftext($im, $fontSize,   0, $xAxis, $yPading * 3 + $marginTop + 3,
            $text_color, $font_regular,"email = $email");
        /*
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 4 + $marginTop + 3,
            $text_color, $font_light, 'serialNumber = 15287582-7');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 5 + $marginTop + 3,
            $text_color, $font_light, 'title = Profesional Sidra');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 6 + $marginTop + 3,
            $text_color, $font_light, 'o = Ministerio de Salud');
        imagettftext($im, $fontSize, 0, $xAxis, $yPading * 7 + $marginTop + 3,
            $text_color, $font_light, 'cn = Autoridad Certificadora del Estado de Chile');
        */

        // Alvaro Raymundo Edgardo Torres Fuchslocher
        // Esteban Alejandro Rojas García
        // Oscar Jesus Zavala Cortés

        /* Obtener Imagen de firma en variable $firma */
        ob_start();
        imagepng($im);
        $firma = base64_encode(ob_get_clean());
        imagedestroy($im);
        //die();

        /* Fin cuadro de firma */

        if($modo == self::modoDesatendidoTest) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';

            $run = 22222222;  // $run = 22222222;
//            $otp = 227083;

            $purpose = 'Desatendido'; // $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';

            /* $pdfbase64 = base64_encode(file_get_contents(public_path('samples/sample3.pdf'))); */
        }
        elseif ($modo == self::modoAtendidoTest) {
            $url = 'https://api.firma.test.digital.gob.cl/firma/v2/files/tickets';
            $api_token = 'sandbox';
            $secret = 'abcd';
            $run = 11111111;
            $otp  = $request->otp;

            $purpose = 'Propósito General';
            $entity = 'Subsecretaría General de La Presidencia';
        } elseif ($modo == self::modoAtendidoProduccion) {
            $url = env('FIRMA_URL');
            $api_token = env('FIRMA_API_TOKEN');
            $secret = env('FIRMA_SECRET');
            $otp  = $request->otp;
            $run = \Auth::id();

            $purpose = 'Propósito General';
            $entity = 'Servicio de Salud Iquique';
        }else{
            session()->flash('warning', 'Modo de firma no seleccionado');
            return redirect()->route('documents.signatures.index', ['pendientes']);
        }

        /* Confección firma en JWT */
        $payload = [
            "purpose"   => $purpose,
            "entity"    => $entity,
            "expiration"=> now()->add(30,'minutes')->format('Y-m-d\TH:i:s'),
            "run"       => $run
        ];

        $jwt = JWT::encode($payload, $secret);
        // die($jwt);


        if($signaturesFlow->type == 'visador') {
            $ct_firmas = $signaturesFlow->signature->signaturesFlows->where('type', 'visador')->count();
            $pocision_firma = $signaturesFlow->sign_position;

            $padding        = 25;
            $coordenada_x   = 65;
            $coordenada_y   = 50 + $padding * $ct_firmas - ($pocision_firma * $padding);
            $ancho          = 170 * 0.9;
            $alto           = 30  * 0.9;
        }
        else if($signaturesFlow->type == 'firmante'){
            $coordenada_x   = 310;
            $coordenada_y   = 49;
            $ancho          = 170 * 1.4;
            $alto           = 30  * 1.4;
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
                                        <llx>". $coordenada_x ."</llx>
                                        <lly>". $coordenada_y ."</lly>
                                        <urx>". ($coordenada_x + $ancho) ."</urx>
                                        <ury>". ($coordenada_y + $alto)  ."</ury>
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
            }else{
                $response = Http::post($url, $data);
            }
        } catch (\GuzzleHttp\Exception\ConnectException | RequestException | Exception $e) {
            var_dump($e);exit();
        }
        $json = $response->json();

//        dd($json);

        if (array_key_exists('error', $json)) {
            session()->flash('warning', $json['error']);
            return redirect()->route('documents.signatures.index', ['pendientes']);
        }

        if (!array_key_exists('content', $json['files'][0])) {
            session()->flash('warning', $json['files'][0]['status']);
            return redirect()->route('documents.signatures.index', ['pendientes']);
        }


////        $data = base64_decode($json['files'][0]['content']);
        $data = $json['files'][0]['content'];

        $signaturesFlow->status = 1;
        $signaturesFlow->signature_date = now();
        $signaturesFlow->save();

        $signaturesFlow->signaturesFile->signed_file = $data;
//        $signaturesFlow->signaturesFile->signed_file = $signaturesFlow->signaturesFile->file;
        $signaturesFlow->signaturesFile->save();

        session()->flash('info', "El documento {$signaturesFlow->signature->id} se ha firmado correctamente.");
        return redirect()->route('documents.signatures.index', ['pendientes']);
    }

}

<?php

namespace App\Http\Controllers\Documents\Sign;

use App\Http\Controllers\Controller;
use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureFlow;
use App\Services\ImageService;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class SignatureController extends Controller
{
    /**
     * Update the status of the signature
     *
     * @param  Signature $signature
     * @param  User $user
     * @param  string $filename
     * @return void
     */
    public function update(Signature $signature, User $user, string $filename)
    {
        /**
         * Obtiene el signatureFlow asociado dado el Signature y el User
         */
        $signatureFlow = SignatureFlow::query()
            ->whereSignatureId($signature->id)
            ->whereSignerId($user->id)
            ->whereStatus('pending')
            ->first();

        /**
         * Actualiza el archivo y el estado en el SignatureFlow
         */
        $signatureFlow->update([
            'file' => 'ionline/sign/signed/'.$filename.'.pdf',
            'status' => 'signed'
        ]);

        /**
         * Actualiza el archivo y el status en Signature
         */
        $signature->update([
            'signed_file' => 'ionline/sign/signed/'.$filename.'.pdf',
            'status' => ($signature->signedByAll == true) ? 'completed' : $signature->status,
        ]);

        session()->flash('success', 'El documento fue firmado exitosamente.');
        return redirect()->route('v2.documents.signatures.index');
    }

    /**
     * Place signature in a position
     *
     * @return void
     */
    public function positionDocumentNumber()
    {
        /**
         * Obtengo en ancho y largo del pdf
         */
        $document = 'samples/document-number.pdf';
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile($document);
        $firstPage = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($firstPage);

        /**
         * Obtengo el base64 del pdf y el checksum
         */
        $base64Pdf = base64_encode(file_get_contents(public_path($document)));
        $checkSumPdf = md5_file(public_path($document));

        /**
         * Obtengo la imagen con el numero de Documento
         */
        $imageWithDocumentNumber = app(ImageService::class)->createDocumentNumber("2342-Xdf4", "13.089");
        ob_start();
        imagepng($imageWithDocumentNumber);
        $signature = base64_encode(ob_get_clean());
        imagedestroy($imageWithDocumentNumber);

        /**
         * Setea las credenciales de la api desde el env
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN');
        $secret = env('FIRMA_SECRET');

        /**
         * Setea la info para firmar un documento
         */
        $purpose = 'Desatendido';
        $entity = env('FIRMA_ENTITY');
        $run = "15287582";
        $page = 'LAST';

        /**
         * Seteo el payload del JWT
         */
        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $run,
        ];

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret, 'HS256');

        /**
         * De milimetros a centimetros
         */
        $widthFile = $size['width'] / 10;
        $heightFile = $size['height'] / 10;

        /**
         * De centimetros a pulgadas y cada pulgada son 72 ppp (dots per inch - dpi)
         */
        $xCoordinate = ($widthFile * 0.393701) * 72;
        $yCoordinate = ($heightFile * 0.393701) * 72;

        /**
         * Descifrar porque hay que restar 230 y 150 a las coordenadas
         */
        $xCoordinate = $xCoordinate - 215;
        $yCoordinate = $yCoordinate - 150;

        /**
         * Largo y ancho de la imagen
         */
        $heightFirma = 200;
        $widthFirma = 100;

        /**
         * Seteo el margin en 110
         */
        $margin = 110;

        $data = [
            'api_token_key' => $apiToken,
            'token' => $jwt,
            'files' => [
                [
                    'content-type' => 'application/pdf',
                    'content' => $base64Pdf,
                    'description' => 'str',
                    'checksum' => $checkSumPdf,
                    'layout' => "
                        <AgileSignerConfig>
                            <Application id=\"THIS-CONFIG\">
                                <pdfPassword/>
                                <Signature>
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                        <llx>" . ($xCoordinate). "</llx>
                                        <lly>" . ($yCoordinate). "</lly>
                                        <urx>" . ($xCoordinate + $heightFirma) . "</urx>
                                        <ury>" . ($yCoordinate + $widthFirma + $margin) . "</ury>
                                        <page>" . $page . "</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$signature</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

        /**
         * Consume la api para firmar
         */
        $response = Http::post($url, $data);
        $json = $response->json();

        /**
         * Verifica si existe un error
         */
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

        /**
         * Retorna el pdf ya firmado
         */
        header('Content-Type: application/pdf');
        echo base64_decode($json['files'][0]['content']);

        die();
    }

    public function showFile(Signature $signature)
    {
        return Storage::disk('gcs')->download($signature->file);
    }

    public function showSignedFile(Signature $signature)
    {
        return Storage::disk('gcs')->download($signature->signed_file);
    }

    public function test()
    {
        $base64 = app(ImageService::class)->createDocumentNumber("2342-Xdf4", "13.089");
        $imagen = '<img src="data:image/png;base64,' . $base64 . '" />';

        return $imagen;
    }
}
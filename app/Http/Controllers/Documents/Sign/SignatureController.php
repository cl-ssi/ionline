<?php

namespace App\Http\Controllers\Documents\Sign;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;


class SignatureController extends Controller
{
    public function positionDocumentNumber()
    {
        /**
         * Obtengo en ancho y largo del pdf
         */
        $document = 'samples/samp_bkp.pdf';
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile($document);
        $pageId = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($pageId);

        /**
         * Obtengo el base64 del pdf y el checksum
         */
        $pdf            = $document;
        $pdfbase64      = base64_encode(file_get_contents(public_path($pdf)));
        $checksum_pdf   = md5_file(public_path($pdf));

        /**
         * Obtengo la imagen del documentNumber
         */
        $imagen_firma = app(ImageService::class)->createDocumentNumber("https://i.saludiquique.gob.cl/validador", "2342-Xdf4", "13.089");
        $name = Str::random();
        $new = imagepng($imagen_firma, "$name.png");
        $firma = base64_encode(ob_get_clean());
        $firma = base64_encode(file_get_contents("$name.png"));
        imagedestroy($imagen_firma);

        /**
         * Setea las credenciales de la api desde el env
         */
        $url        = env('FIRMA_URL');
        $api_token  = env('FIRMA_API_TOKEN');
        $secret     = env('FIRMA_SECRET');

        /**
         * Setea la info para firmar un documento
         */
        $purpose    = 'Desatendido';
        $entity     = 'Servicio de Salud Iquique';
        $run        = "15287582";
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
        $jwt = JWT::encode($payload, $secret);

        /**
         * De milimetros a centimetros
         */
        $widthFile = $size['width'] / 10;
        $heightFile = $size['height'] / 10;

        /**
         * De centimetros a pulgadas
         */
        $coordenada_x = ($widthFile * 0.393701) * 72;
        $coordenada_y = ($heightFile * 0.3937) * 72;


        /**
         * Descifrar porque hay que restar 230 y 150 a las coordenadas
         */
        $coordenada_x = $coordenada_x - 230;
        $coordenada_y = $coordenada_y - 150;

        /**
         * Largo y ancho de la imagen
         */
        $largoFirma = 200;
        $widthFirma = 100;

        /**
         * Seteo el margin en 110
         */
        $margin = 110;

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
                                    <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                        <llx>" . ($coordenada_x). "</llx>
                                        <lly>" . ($coordenada_y). "</lly>
                                        <urx>" . ($coordenada_x + $largoFirma) . "</urx>
                                        <ury>" . ($coordenada_y + $widthFirma + $margin) . "</ury>
                                        <page>" . $page . "</page>
                                        <image>BASE64</image>
                                        <BASE64VALUE>$firma</BASE64VALUE>
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
}
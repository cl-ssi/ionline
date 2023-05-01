<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Correlative;
use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class EnumerateSignature extends Component
{
    public $signature;

    public function render()
    {
        return view('livewire.sign.enumerate-signature');
    }

    protected $listeners = [
        'enumerate'
    ];

    public function enumerate()
    {
        $signature = $this->signature;

        /**
         * Muestra un mensaje de error en caso de estar enumerado un documento o incompleto.
         */
        if(! $signature->isCompleted())
        {
            session()->flash('danger', 'El documento no esta completado o ya esta enumerado');
            return redirect()->route('v2.documents.signatures.index', ['pendientes']);
        }

        /**
         * Obtengo el link del documento
         */
        Storage::disk('gcs')->exists($signature->signed_file);
        $document = Storage::disk('gcs')->url($signature->signed_file);
        // $signature->file_signed;
        $document = 'http://ionline.test/storage/ionline/signatures/original/63689.pdf';
        $document = 'http://ionline.test/storage/ionline/signatures/original/15017.pdf';

        /**
         * Guarda el numero correlativo en Signature
         */
        $signature->update([
            'number' => Correlative::getCorrelativeFromType($signature->type_id),
            'verification_code' => Signature::getVerificationCode($signature),
        ]);

        /**
         * Obtiene el ancho y largo del pdf
         */
        $fileContent = file_get_contents($document);
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile(StreamReader::createByString($fileContent));
        $firstPage = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($firstPage);

        /**
         * Obtiene el base64 del pdf y el checksum
         */
        $base64Pdf = base64_encode(file_get_contents($document));
        $checkSumPdf = md5_file($document);

        /**
         * Obtiene la imagen con el numero de Documento
         */
        $imageWithDocumentNumber = app(ImageService::class)->createDocumentNumber($signature->verification_code, $signature->number);
        ob_start();
        imagepng($imageWithDocumentNumber);
        $signatureBase64 = base64_encode(ob_get_clean());
        imagedestroy($imageWithDocumentNumber);

        /**
         * Setea las credenciales de la api desde el env
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN');
        $secret = env('FIRMA_SECRET');
        $runUnattended = '15287582';

        /**
         * Setea la info para firmar un documento
         */
        $purpose = 'Desatendido';
        $entity = 'Servicio de Salud Iquique';
        $page = 'LAST';

        /**
         * Setea el payload del JWT
         */
        $payload = [
            "purpose" => $purpose,
            "entity" => $entity,
            "expiration" => now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
            "run" => $runUnattended,
        ];

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret);

        /**
         * Calculo de milimetros a centimetros
         */
        $widthFile = $size['width'] / 10;
        $heightFile = $size['height'] / 10;

        /**
         * Parsea de centimetros a pulgadas y cada pulgada son 72 ppp (dots per inch - dpi)
         */
        $xCoordinate = ($widthFile * 0.393701) * 72;
        $yCoordinate = ($heightFile * 0.393701) * 72;

        /**
         * Descifrar porque hay que restar 220 y 135 a las coordenadas
         */
        $xCoordinate = $xCoordinate - 220;
        $yCoordinate = $yCoordinate - 135;

        /**
         * Largo y ancho de la imagen
         */
        $heightFirma = 200;
        $widthFirma = 100;

        /**
         * Setea el margin en 110 o 110
         */
        $margin = 60;

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
                                        <BASE64VALUE>$signatureBase64</BASE64VALUE>
                                    </Visible>
                                </Signature>
                            </Application>
                        </AgileSignerConfig>"
                ]
            ]
        ];

        /**
         * Peticion la api para firmar
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
         * Guardar el archivo enumerado en disco
         */
        $folder = Signature::getFolderEnumerate();
        $filename = $folder . "/" . $signature->number . "-". now()->timestamp;
        $file = $filename.".pdf";

        Storage::disk('gcs')
            ->getDriver()
            ->put($file, base64_decode($json['files'][0]['content']), ['CacheControl' => 'no-store']);


        session()->flash('success', 'El documento fue enumerado exitosamente');
        return redirect()->route('v2.documents.signatures.index');

        /**
         * Retorna el pdf ya firmado
         */
        header('Content-Type: application/pdf');
        echo base64_decode($json['files'][0]['content']);

        die();
    }
}

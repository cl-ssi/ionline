<?php

namespace App\Models\Documents;

use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Firebase\JWT\JWT;
use App\Services\ImageService;

class DigitalSignature extends Model
{
    /**
     * Posición de la firma, (def)
     *  ------------------------------------
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |                                    |
     * |          (left)  (center)  (right) |
     * | (second)   XXX      XXX      XXX   |
     * | (first)    XXX      XXX     (def)  |
     * |  margin-bottom: 72.3               |
     *  ------------------------------------
     * 
     * EJEMPLO FIRMA DIGITAL
     * =====================
     **/
    // $user = User::find(15287582);
    // $otp = '123456';

    // $files[] = Storage::get('ionline/samples/oficio.pdf');
    // $positions[] = [ // opcional (Default: right, first, 0)
    //     'column'        => 'right',   // 'left','center','right'
    //     'row'           => 'first',   // 'first','second'
    //     'margin-bottom' => 20,        // subir 20 pixeles hacia arriba
    // ];

    // $files[] = Storage::get('ionline/samples/oficio_firmado_1.pdf');
    // $positions[] = []; // Puede ser un array vacio, por defecto será: Right, First, 0

    // $digitalSignature = new DigitalSignature();
    // $success = $digitalSignature->signature($user, $otp, $files, $positions);


    /** 
     * EJEMPLO NUMERAR DOCUMENTO
     * =========================
     **/
    // $user = User::find(15287582);
    // $file = Storage::get('ionline/samples/oficio_firmado_2.pdf');
    // $verificationCode = '002342-Xdf4';
    // $number = '13.089';

    // $digitalSignature = new DigitalSignature();
    // $success = $digitalSignature->numerate($user, $file, $verificationCode, $number);

    /** 
     * RESULTADO
     * ===============
     **/
    // if($success) {
    //     return $digitalSignature->streamFirstSignedFile();
    // }
    // else {
    //     echo $digitalSignature->error;
    // }

    /** 
     * Stream una vista blade a una variable 
     */
    // $file = Pdf::loadView('documents.templates.memo', [
    //     'document' => $document
    // ])->output();

    use HasFactory;

    private $url;
    private $user;
    private $data;
    private $page;
    private $signatureBase64;
    private $signatureWidth;
    private $signatureHeight;

    public $response;
    public $error = null;

    /** 
     * Factor es una proporción fija para reducir la imagen de la firma
     * Este nuevo tamaño se envia junto con la imagen a incrustar en el pdf,
     * esto hace que aparezca un rectangulo clickeable al rededor de la firma
     * proporcional al tamaño de la imágen.
     */
    private $factorWidth  = 0.172;
    private $factorHeight = 0.189;

    /**
     * Configuración inicial
     * Variables y token
     */
    public function setConfig($user, $type)
    {
        $this->user = $user;

        switch($type) {
            case 'signature':
                $purpose = 'Propósito General';
                $secret = env('FIRMA_SECRET');
                $this->data['api_token_key'] = env('FIRMA_API_TOKEN');
                break;
            case 'numerate': 
                $purpose = 'Desatendido';
                $secret = env('FIRMA_SECRET_IONLINE');
                $this->data['api_token_key'] = env('FIRMA_API_TOKEN_IONLINE');
                break;
        }

        $this->url = env('FIRMA_URL');

        $entity = env('FIRMA_ENTITY');
        $payload = [
            "purpose"   => $purpose,
            "entity"    => $entity,
            "run"       => $user->id,
            "expiration"=> now()->add(30, 'minutes')->format('Y-m-d\TH:i:s'),
        ];

        $this->data['token'] = JWT::encode($payload, $secret, 'HS256');
    }

    /**
     * Firma Normal
     */
    public function signature($user, $otp, $files, $positions)
    {
        if(count($files) != count($positions)) {
            abort( response()->json('Error: La cantidad de archivos a firmar no coincide la cantidad posiciones suministrada, informe esto a los desarrolladores', 406) );
        } 
        $this->setConfig($user,'signature');

        /** En que página va la firma */
        $this->page = 'LAST';

        /** Obtener la imagen de la firma */
        $this->signatureBase64 = app(ImageService::class)->createSignature($this->user);

        /** Tamaño de la imagen de la firma x el factor */
        $this->signatureWidth = 930 * $this->factorWidth;   // = 160
        $this->signatureHeight = 206 * $this->factorHeight; // =  39

        $coordinates = $this->calculateSignaturesCoordinates($positions);

        $this->data['files'] = $this->generateFilesData($files, $coordinates);

        return $this->sendToSign($otp);
    }

    /**
     * Numerar un PDF firmado
     */
    public function numerate($user, $file, $verificationCode, $number)
    {
        $this->setConfig($user,'numerate');

        /** En que página va la firma */
        $this->page = '1';

        /** Obtener la imagen de la firma */
        $this->signatureBase64 = app(ImageService::class)->createDocumentNumber($verificationCode, $number);

        /** Tamaño de la firma de foliado x el factor */
        $this->signatureWidth = 1100 * $this->factorWidth;
        $this->signatureHeight = 280 * $this->factorHeight;

        $coordinate = $this->calculateNumerateCoordinates($file);

        /** Pasar el archivo y la coordenada a un arreglo, ya que la siguiente funcion acepta solo arreglos */
        $files[] = $file;
        $coordinates[] = $coordinate;

        $this->data['files'] = $this->generateFilesData($files, $coordinates);

        return $this->sendToSign();
    }

    /**
     * Generar el layout por cada archivo
     */
    public function generateFilesData($files, $coordinates)
    {
        foreach($files as $key => $file) {
            $content = base64_encode($file);
            $checksum = md5($content);

            $data['files'][] = [
                'content-type' => 'application/pdf',
                'content' => $content,
                'description' => 'str',
                'checksum' => $checksum,
                'layout' => "
                    <AgileSignerConfig>
                        <Application id=\"THIS-CONFIG\">
                            <pdfPassword/>
                            <Signature>
                                <Visible active=\"true\" layer2=\"false\" label=\"true\" pos=\"2\">
                                    <llx>" . ($coordinates[$key]['x']). "</llx>
                                    <lly>" . ($coordinates[$key]['y']). "</lly>
                                    <urx>" . ($coordinates[$key]['x'] + $this->signatureWidth) . "</urx>
                                    <ury>" . ($coordinates[$key]['y'] + $this->signatureHeight) . "</ury>
                                    <page>" . $this->page . "</page>
                                    <image>BASE64</image>
                                    <BASE64VALUE>" . $this->signatureBase64 . "</BASE64VALUE>
                                </Visible>
                            </Signature>
                        </Application>
                    </AgileSignerConfig>"
            ];
        }

        return $data['files'];
    }

    /**
     * Enviar a firmar, esto devuelve un true or false en caso de error
     * los mensajes de error quedan en $digitalSignature->error
     */
    public function sendToSign($otp = null)
    { 
        /**
         * Peticion a la api para firmar
         */
        try {
            $this->response = Http::withHeaders(['otp' => $otp])->post($this->url, $this->data);

            if($this->response->failed()) {
                $this->error = $this->response->reason();
            }

            if(array_key_exists('error',$this->response->json())) {
                $this->error = $this->response->json()['error'];
            }
        } catch (\Throwable $th) {
            $this->error = "No se pudo conectar a firma gobierno. ". $th->getCode();
        }

        return $this->error ? false: true;
    }

    /**
     * Calcula la posición de la firma
     */
    public function calculateSignaturesCoordinates($positions)
    {
        foreach($positions as $position) {
            /** Posición por defecto,  */
            if ( !array_key_exists('column', $position) || is_null($position['column']) ) {
                $position['column'] = 'right';
            }
            if ( !array_key_exists('row',$position) || is_null($position['row']) ) {
                $position['row'] = 'first';
            }
            if ( !array_key_exists('margin-bottom',$position) || is_null($position['margin-bottom']) ) {
                $position['margin-bottom'] = 0;
            }

            switch($position['column']) {
                case 'left':
                    $coordinates['x'] = 93.3; // Left
                    break;
                case 'center':
                    $coordinates['x'] = 256.4; // Center
                    break;
                case 'right':
                    $coordinates['x'] = 418.8; // Right
                    break;
            }

            switch($position['row']) {
                case 'first':
                    $coordinates['y'] = 72.3 + $position['margin-bottom'];
                    break;
                case 'second':
                    $coordinates['y'] = 110.4 + $position['margin-bottom'];
                    break;
            }

            $coordinates[] = $coordinates;
        }
        return $coordinates;
    }


    /**
     * Get pdf page size para numerar
     */
    public function calculateNumerateCoordinates($file)
    {
        /** Obtener el tamaño de la página */
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile(StreamReader::createByString($file));
        $firstPage = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($firstPage);

        /**
         * Calculo de milimetros a centimetros
         */
        $widthFile = $size['width'] / 10;
        $heightFile = $size['height'] / 10;

        /**
         * Calculo de centimetros a pulgadas y cada pulgada son 72 ppp (dots per inch - dpi)
         */
        $xCoordinate = ($widthFile * 0.393701) * 72;
        $yCoordinate = ($heightFile * 0.393701) * 72;

        /**
         * Resta margenes 218 y 84 a las coordenadas
         */
        $coordinates['x'] = $xCoordinate -= 218;
        $coordinates['y'] = $yCoordinate -= 84;

        return $coordinates;
    }

    /**
     * Stream first file to browser
     */
    public function streamFirstSignedFile()
    {
        $pdfContent = base64_decode($this->response['files'][0]['content']);

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }

    /**
     * Store first file to storage path $filename = 'ionline/folder/file.pdf'
     */
    public function storeFirstSignedFile($filename)
    {
        $pdfContent = base64_decode($this->response['files'][0]['content']);
        return Storage::put($filename, $pdfContent, ['CacheControl' => 'no-store']);
    }

    /**
     * Store file to storage: $key [0,1..] y $filename = 'ionline/folder/filename1.pdf'
     */
    public function storeSignedFile($key, $filename)
    {
        $pdfContent = base64_decode($this->response['files'][$key]['content']);
        return Storage::put($filename, $pdfContent, ['CacheControl' => 'no-store']);
    }


    /**
     * Esto no se está ocupando, es para guardar el código de como firmar un PDF con una firma
     * electronica utilizando un certificado pfx convertido a cert y key
     * o bien uno generado directamente con openssl 
     * $ openssl pkcs12 -in firma.pfx -out firma.crt -nodes
     * 
     */
    public static function localSign() {
        // tinker > App\Models\Documents\DigitalSignature::localSign()
        $certificate = '-----BEGIN CERTIFICATE-----...';

        $private = '-----BEGIN PRIVATE KEY-----...';

        // Hay que instalar este paquete
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $pages = $pdf->setSourceFile('/home/atorres/signatures/85.pdf');
        for ($pageNo = 1; $pageNo <= $pages; $pageNo++) {
            $page = $pdf->importPage($pageNo);

            $size = $pdf->getTemplateSize($page);

            // create a page (landscape or portrait depending on the imported page size)
            if ($size[0] > $size[1]) {
                $pdf->AddPage('L', [$size[0], $size[1]]);
            } else {
                $pdf->AddPage('P', [$size[0], $size[1]]);
            }

            print_r($size);
            // $pdf->AddPage();
            $pdf->useTemplate($page, 0, 0);
            // use the imported page
            if ($pageNo == 1) {

                $info = [
                    'Name' => 'Servicio de Salud Tarapaca',
                    'Location' => 'Tarapaca',
                    'Reason' => 'Numeracion',
                    'ContactInfo' => 'sistemas.sst@redsalud.gob.cl',
                ];

                // Obtener la imagen de la firma en base64
                //$signatureBase64 = app(ImageService::class)->createDocumentNumber($verificationCode, $number);

                //Obtener $alto y $ancho de la imagen
                $ancho = 60;
                $alto = 14;

                // Coordenadas de la firma esquina superior izquierda
                $eje_x = 155.9;
                $eje_y = 0;

                // Firmado propiamente tal
                $pdf->setSignature($certificate, $private, '', '', 2, $info, 'A');
                // A: Para firma, null para certificado

                // Poner la firma en el PDF
                // Arriba está signatureBase64  $pdf->MemImage($variable con la imagen)
                $pdf->Image('firma-template.png', $eje_x, $eje_y, $ancho, $alto, 'PNG');

                // Definir el área activa de la firma en el pdf
                $pdf->setSignatureAppearance($eje_x, $eje_y, $ancho, $alto);
            }

        }

        // Guardar el PDF firmado en el directorio $out
        $output_file = '/home/atorres/signatures/out.pdf';
        $pdf->Output($output_file, 'F');
    }
}

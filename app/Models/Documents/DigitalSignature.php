<?php

namespace App\Models\Documents;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use setasign\Fpdi\Fpdi;
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
     * $user = User::find(15287582);
     * $digitalSignature = new DigitalSignature($user, 'signature');
     *
     * $files[] = public_path('samples/oficio_firmado_1.pdf');
     * $files[] = public_path('samples/oficio_firmado_2.pdf');
     * $otp = '123456';
     * $position = [
     *     'column'        => 'right',   // 'left','center','right'
     *     'row'           => 'first',   // 'first','second'
     *     'margin-bottom' => 20,        // 80 pixeles
     * ];
     * $signed = $digitalSignature->signature($files, $otp, $position);
     * 
     * 
     * EJEMPLO NUMERAR DOCUMENTO
     * =========================
     * $user = User::find(15287582);
     * $digitalSignature = new DigitalSignature($user, 'numerate');
     * $file = public_path('samples/oficio_firmado_1.pdf');
     * $verificationCode = '002342-Xdf4';
     * $number = '13.089';
     * $signed = $digitalSignature->numerate($file, $verificationCode, $number);
     * 
     * 
     * RESULTADO
     * ===============
     * if($signed) {
     *     return $digitalSignature->streamFirstSignedFile();
     * }
     * else {
     *     echo $digitalSignature->error;
     * }
     */

    use HasFactory;

    private $url;
    private $user;
    private $data;
    private $page;
    private $signatureBase64;
    private $signatureWidth;
    private $signatureHeight;
    private $xCoordinate;
    private $yCoordinate;

    public $response;
    public $error = null;
    /** 
     * Factor de reducción de imagen de firma.
     * Es una proporción de la imagen, que permite que en el pdf 
     * aparezca un rectangulo clickeable al rededor de la firma.
     **/
    private $factorWidth  = 0.172;
    private $factorHeight = 0.189;

    /**
     * En el constructor se setean las variables comunes
     * $type = 'signature','numerate'
    */
    public function __construct($user, $type)
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
                $secret = env('FIRMA_SECRET_DESATENDIDO');
                $this->data['api_token_key'] = env('FIRMA_API_TOKEN_DESATENDIDO');
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
    public function signature($files, $otp, $position = null)
    {
        /** En que página va la firma */
        $this->page = 'LAST';

        /** Obtener la imagen de la firma */
        $this->signatureBase64 = app(ImageService::class)->createSignature($this->user);

        /** Tamaño de la imagen de la firma x el factor */
        $this->signatureWidth = 930 * $this->factorWidth;   // = 160
        $this->signatureHeight = 206 * $this->factorHeight; // =  39

        $this->calculateSignaturePosition($position);

        $this->data['files'] = $this->generateFilesData($files);

        return $this->sendToSign($otp);
    }

    /**
    * Numerar un PDF firmado
    */
    public function numerate($file, $verificationCode, $number)
    {
        /** En que página va la firma */
        $this->page = '1';

        /** Obtener la imagen de la firma */
        $this->signatureBase64 = app(ImageService::class)->createDocumentNumber($verificationCode, $number);

        /** Tamaño de la firma de foliado x el factor */
        $this->signatureWidth = 1100 * $this->factorWidth;
        $this->signatureHeight = 280 * $this->factorHeight;

        $this->calculateNumeratePosition($file);

        $files[] = $file;
        $this->data['files'] = $this->generateFilesData($files);

        return $this->sendToSign();
    }

    /**
    * Generar el layout por cada archivo
    */
    public function generateFilesData($files)
    {
        foreach($files as $file) {
            $content = base64_encode(file_get_contents($file));
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
                                    <llx>" . ($this->xCoordinate). "</llx>
                                    <lly>" . ($this->yCoordinate). "</lly>
                                    <urx>" . ($this->xCoordinate + $this->signatureWidth) . "</urx>
                                    <ury>" . ($this->yCoordinate + $this->signatureHeight) . "</ury>
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
     * Sign
     */
    public function sendToSign($otp = null)
    {
        /**
         * Peticion a la api para firmar
         */
        try {
            $response = Http::withHeaders(['otp' => $otp])->post($this->url, $this->data);
        } catch (\Throwable $th) {
            $this->error = "No se pudo conectar a firma gobierno. ". $th->getCode();
        }
        
        if($response->failed()) {
            $this->error = $response->reason();
        }
        
        $this->response = $response->json();
        
        if(array_key_exists('error',$this->response)) {
            $this->error = $this->response['error'];
        }

        return $this->error ? false: true;
    }

    /**
    * Get pdf page size para numerar
    */
    public function calculateNumeratePosition($file)
    {
        /** Obtener el tamaño de la página */
        $pdf = new Fpdi('P', 'mm');
        $pdf->setSourceFile($file);
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
         * Resta 290 y 120 a las coordenadas
         */
        $this->xCoordinate = $xCoordinate -= 218;
        $this->yCoordinate = $yCoordinate -= 84;
    }

    /**
     * Calcula la posición de la firma
     */
    public function calculateSignaturePosition($position = null)
    {
        if( !$position ) {
            /** Posición por defecto,  */
            $position = [
                'column'        => 'right',   // 'left','center','right'
                'row'           => 'first',   // 'first','second'
                'margin-bottom' => 0,         // 80 pixeles
            ];
        }

        switch($position['column']) {
            case 'left':
                $this->xCoordinate = 93.3; // Left
                break;
            case 'center':
                $this->xCoordinate = 256.4; // Center
                break;
            case 'right':
                $this->xCoordinate = 418.8; // Right
                break;
        }

        switch($position['row']) {
            case 'first':
                $this->yCoordinate = 72.3 + $position['margin-bottom'];
                break;
            case 'second':
                $this->yCoordinate = 110.4 + $position['margin-bottom'];
                break;
        }

    }

    /**
    * stream first file to browser
    */
    public function streamFirstSignedFile()
    {
        $pdfBase64 = base64_decode($this->response['files'][0]['content']);

        return response($pdfBase64, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="document.pdf"',
        ]);
    }
}

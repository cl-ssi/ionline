<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SignDocument extends Component
{
    /**
     * Indica si debe estar deshabilitado el boton de firmar
     *
     * @var bool
     */
    public $disabled;

    /**
     * Id de la firma para el modal
     *
     * @var string
     */
    public $signatureId;

    /**
     * Link del Documento a firmar
     *
     * @var string
     */
    public $link;

    /**
     * Carpeta donde se guardara el documento firmado
     *
     * @var string
     */
    public $folder;

    /**
     * Nombre del archivo del documento firmado
     *
     * @var string
     */
    public $filename;

    /**
     * Usuario que firma
     *
     * @var mixed
     */
    public $user;

    /**
     * Eje y para ubicar la firma
     *
     * @var int
     */
    public $y;

    /**
     * Eje x para ubicar la firma
     *
     * @var int
     */
    public $x;

    /**
     * Route a redirigir
     *
     * @var string
     */
    public $route;

    /**
     * Parametros de la ruta a redirigir
     *
     * @var array
     */
    public $routeParams;

    /**
     * OTP
     *
     * @var string
     */
    public $otp;

    public function render()
    {
        return view('livewire.sign.sign-document');
    }

    public function signDocument()
    {
        /**
         * Obtiene el usuario autenticado
         */
        $user = $this->user;

        /**
         * Setea el otp
         */
        $otp = $this->otp;

        /**
         * Obtiene el link del documento
         */
        $document = $this->link;

        /**
         * Obtiene el base64 del pdf y el checksum
         */
        $base64Pdf = base64_encode(file_get_contents($document));
        $checkSumPdf = md5_file($document);

        /**
         * Obtiene la imagen con el numero de Documento
         */
        $imageWithDocumentNumber = app(ImageService::class)->createSignature($user);
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

        /**
         * Setea la info para firmar un documento
         */
        $page = 'LAST';

        /**
         * Setea el modo para el payload
         */
        if(env('FIRMA_MODO') == 'test')
        {
            $modo = Signature::modoAtendidoTest();
        }
        else
        {
            $modo = Signature::modoAtendidoProduccion();
        }

        /**
         * Setea el payload del JWT
         */
        $payload = app(Signature::class)->getPayload($modo, $user->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret);

        /**
         * Asigna coordenadas
         */
        $xCoordinate = $this->x;
        $yCoordinate = $this->y;

        /**
         * Largo y ancho de la imagen
         */
        $heightFirma = 200;
        $widthFirma = 100;

        /**
         * Set the file data
         */
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
                                        <ury>" . ($yCoordinate + $widthFirma + 5) . "</ury>
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
         * Peticion a la api para firmar
         */
        $response = Http::withHeaders(['otp' => $otp])->post($url, $data);

        $json = $response->json();

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json)) {

            session()->flash('danger', 'El proceso de firma produjo un error. Codigo 1');
            return redirect()->route('v2.documents.signatures.index');

            return ['statusOk' => false,
                'content' => '',
                'errorMsg' => $json['error'],
            ];
        }

        if (!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                session()->flash('danger', 'El proceso de firma produjo un error. Codigo 2');
                return redirect()->route('v2.documents.signatures.index');
            }
            else
            {
                session()->flash('danger', 'El proceso de firma produjo un error. Codigo 3');
                return redirect()->route('v2.documents.signatures.index');
            }

        }

        /**
         * Guardar el archivo firmado en disco
         */
        $filename = $this->folder . $this->filename;
        $file = $filename.".pdf";

        Storage::disk('gcs')
            ->getDriver()
            ->put($file, base64_decode($json['files'][0]['content']), ['CacheControl' => 'no-store']);

        session()->flash('success', 'El documento fue firmado exitosamente');
        return redirect()->route($this->route, $this->routeParams);
    }
}

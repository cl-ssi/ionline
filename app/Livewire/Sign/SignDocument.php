<?php

namespace App\Livewire\Sign;

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
     * Fila para ubicar la firma
     *
     * @var int
     */
    public $row;

    /**
     * Columna para ubicar la firma
     *
     * @var string
     */
    public $column;

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
         * Obtiene la imagen de la firma
         */
        $signatureBase64 = app(ImageService::class)->createSignature($this->user);

        /**
         * Setea las credenciales de la api
         */
        $url = env('FIRMA_URL');
        $apiToken = env('FIRMA_API_TOKEN');
        $secret = env('FIRMA_SECRET');

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
        $payload = app(Signature::class)->getPayload($modo, $this->user->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret, 'HS256');

        /**
         * Asigna coordenadas
         */
        $xCoordinate = app(Signature::class)->calculateColumn($this->column);
        $yCoordinate = app(Signature::class)->calculateRow($this->row);

        /**
         * Set the file data
         */
        $documentBase64Pdf = base64_encode(file_get_contents($this->link));
        $data = app(Signature::class)->getData($documentBase64Pdf, $jwt, $signatureBase64, $apiToken, $xCoordinate, $yCoordinate, false);

        /**
         * Peticion a la api para firmar
         */
        $response = Http::withHeaders(['otp' => $this->otp])->post($url, $data);

        $json = $response->json();

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json))
        {
            $message = $json['error'];
        }
        elseif(!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                $message = $json['error'];
            }
            else
            {
                $message = $json['files'][0]['status'];
            }
        }

        if(isset($message))
        {
            session()->flash('danger', "Error: $message");
            return redirect()->route('v2.documents.signatures.index');
        }

        /**
         * Guardar el archivo firmado en disco
         */
        $filename = $this->folder . $this->filename;
        $file = $filename.".pdf";
        $contentFile = base64_decode($json['files'][0]['content']);

        Storage::put($file, $contentFile, ['CacheControl' => 'no-store']);

        session()->flash('success', 'El documento fue firmado exitosamente');
        return redirect()->route($this->route, $this->routeParams);
    }
}

<?php

namespace App\Services;

use App\Exceptions\ExceptionSignService;
use App\Models\Documents\Sign\Signature;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DocumentSignService
{
    /**
     * Link del Documento a firmar
     *
     * @var string
     */
    public $document;

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
     * Coordenada en X para ubicar la firma
     *
     * @var int
     */
    public $xCoordinate;

    /**
     * Coordenada en Y para ubicar la firma
     *
     * @var string
     */
    public $yCoordinate;

    /**
     * Indica la imagen a poner por firma
     *
     * @var string
     */
    public $base64Image;

    /**
     * Pagina donde se ubica la firma
     *
     * @var [type]
     */
    public $page;

    /**
     * OTP
     *
     * @var string
     */
    public $otp;

    /**
     * Modo
     *
     * @var string
     */
    public $modo;

    public function __construct()
    {
        /**
         * Setea el page por defecto en LAST
         */
        $this->page = 'LAST';
    }

    /**
     * @param  string  $document
     * @return void
     */
    public function setDocument(string $document)
    {
        $this->document = $document;
    }

    /**
     * @param  string  $folder
     * @return void
     */
    public function setFolder(string $folder)
    {
        $this->folder = $folder;
    }

    /**
     * @param  string  $filename
     * @return void
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param  User  $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param  integer  $xCoordinate
     * @return void
     */
    public function setXCoordinate(int $xCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
    }

    /**
     * @param  int  $yCoordinate
     * @return void
     */
    public function setYCoordinate(int $yCoordinate)
    {
        $this->yCoordinate = $yCoordinate;
    }

    /**
     * @param  string  $base64Image
     * @return void
     */
    public function setBase64Image(string $base64Image)
    {
        $this->base64Image = $base64Image;
    }

    /**
     * @param  string  $page
     * @return void
     */
    public function setPage(string $page)
    {
        $this->page = $page;
    }

    /**
     * @param  string  $otp
     * @return void
     */
    public function setOtp(string $otp)
    {
        $this->otp = $otp;
    }

    /**
     * @param  string  $modo
     * @return void
     */
    public function setModo(string $modo)
    {
        $this->modo = $modo;
    }

    /**
     * Firma el documento
     *
     * @return mixed
     */
    public function sign()
    {
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
            if($this->modo = 'ATENDIDO')
            {
                $modo = Signature::modoAtendidoTest();
            }
            elseif($this->modo = 'DESATENDIDO')
            {
                $modo = Signature::modoDesatendidoTest();
            }
        }
        else
        {
            if($this->modo = 'ATENDIDO')
            {
                $modo = Signature::modoAtendidoProduccion();
            }
            elseif($this->modo = 'DESATENDIDO')
            {
                $modo = Signature::modoDesatendidoProduccion();
            }
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
         * Set the file data
         */
        $data = app(Signature::class)->getData($this->document, $jwt, $this->base64Image, $apiToken, $this->xCoordinate, $this->yCoordinate, false, $this->page);

        /**
         * Peticion a la api para firmar
         */
        try {
            $response = Http::withHeaders(['otp' => $this->otp])->post($url, $data);
        } catch (\Throwable $th) {
            throw new Exception("No se pudo conectar a firma gobierno.", $th->getCode());
        }

        if($response->failed()) {
            throw new ExceptionSignService($response->reason(), $response->getStatusCode());
        }

        $json = $response->json();

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json))
        {
            throw new ExceptionSignService($json['error'], '01');
        }

        if (!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                throw new ExceptionSignService($json['error'], '02');
            }
            else
            {
                throw new ExceptionSignService($json['files'][0]['status'], '03');
            }
        }

        /**
         * Guardar el archivo firmado en disco
         */
        $filename = $this->folder . $this->filename;
        $file = $filename.".pdf";

        Storage::disk('gcs')->put(
            $file,
            base64_decode($json['files'][0]['content']),
            ['CacheControl' => 'no-store']
        );

        return $json;
    }
}

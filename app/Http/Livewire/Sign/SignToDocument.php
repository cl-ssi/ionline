<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SignToDocument extends Component
{
    public $btn_title = 'Firmar';
    public $btn_class = 'btn btn-primary';
    public $btn_icon = 'fas fa-fw fa-signature';

    public $showModal = null;

    public $otp;

    public $view;
    public $viewData;
    public $pdfBase64;

    public $position;
    public $row = 1;
    public $startY;

    public $signer;
    public $folder;
    public $filename;
    public $callback;
    public $callbackParams;

    public function render()
    {
        return view('livewire.sign.sign-to-document');
    }

    public function show()
    {
        /**
         * Obtiene el base del pdf
         */
        $documentFile = \PDF::loadView($this->view, $this->viewData);
        $this->pdfBase64 = base64_encode($documentFile->output());

        /**
         * Setea el otp y showModal
         */
        $this->otp = null;
        $this->showModal = 'd-block';
    }

    public function dismiss()
    {
        /** Codigo al cerrar el modal */
        $this->showModal = null;
    }

    public function signDocument()
    {
        /**
         * Obtiene la imagen de la firma
         */
        $signatureBase64 = app(ImageService::class)->createSignature($this->signer);

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
        $payload = app(Signature::class)->getPayload($modo, $this->signer->id);

        /**
         * Convierte y firma un objeto de php a un string de JWT
         */
        $jwt = JWT::encode($payload, $secret, 'HS256');

        /**
         * Asigna coordenadas
         */
        $xCoordinate = app(Signature::class)->calculateColumn($this->position);
        $yCoordinate = app(Signature::class)->calculateRow($this->row, $this->startY);

        /**
         * Set the file data
         */
        $data = app(Signature::class)->getData($this->pdfBase64, $jwt, $signatureBase64, $apiToken, $xCoordinate, $yCoordinate, false);

        /**
         * Peticion a la api para firmar
         */
        try {
            $response = Http::withHeaders(['otp' => $this->otp])->post($url, $data);
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', "Disculpe, se produjo un error con firma electrónica, intente nuevamente.");
        }

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

        /**
         * Muestra el mensaje de error
         */
        if(isset($message))
        {
            return redirect()->back()->with('danger', "Error: $message");
        }

        /**
         * Obtiene el archivo, la carpeta y el nombre del archivo
         */
        $filename = $this->folder . $this->filename;
        $file = $filename.".pdf";
        $contentFile = base64_decode($json['files'][0]['content']);

        /**
         * Guarda el archivo en el storage
         */
        Storage::disk('gcs')->put($file, $contentFile, ['CacheControl' => 'no-store']);

        /**
         * Setea los inputs
         */
        $this->resetInputs();

        /**
         * Redirige al callback
         */
        return redirect()->route($this->callback, $this->callbackParams);
    }

    public function resetInputs()
    {
        $this->showModal = null;
        $this->otp;
    }
}

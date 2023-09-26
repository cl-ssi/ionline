<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\Signature;
use App\Services\ImageService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
class SignToDocument extends Component
{
    /**
     * Ejemplo de uso:
     *
     *   @livewire('sign.sign-to-document', [
     *       'signer' => auth()->user(),
     *
     *       'view' => 'dte.reception-certificate',
     *       'viewData' => [
     *           'param1' => 1,
     *           'param2' => '2',
     *       ],
     *
     *       'filename' => '/ionline/dte/confirmation/confirmation-'.$dte->id,
     *
     *       'fileLink' => 'http://localhost/pdf/filename.pdf',
     *
     *       'routeName' => 'my.route.name',
     *       'routeParams' => json_decode([]),
     *
     *       'position' => 'center',
     *       'startY' => 80,
     *
     *       'btn_title' => 'Aceptar',
     *       'btn_class' => 'btn btn-success',
     *       'btn_icon'  => 'fas fa-fw fa-thumbs-up',
     *
     *       'callback' => 'finance.dtes.confirmation.store',
     *       'callbackParams' => [
     *           'dte' => $dte->id,
     *           'filename' => '/ionline/dte/confirmation-'.$dte->id,
     *           'confirmation_observation' => $confirmation_observation,// Probar
     *       ]
     *   ])
     */

    public $btn_title = 'Firmar';
    public $btn_class = 'btn btn-primary';
    public $btn_icon = 'fas fa-fw fa-signature';

    public $showModal = null;

    public $otp;

    public $view;
    public $viewData;

    public $fileLink;

    public $routeName;
    public $routeParams;

    public $pdfBase64;

    public $position = 'center';
    public $row = 1;
    public $startY = 80;

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
        if(isset($this->fileLink))
        {
            /**
             * Si esta seteado el fileLink, se obtiene el base64 del link
             */
            $this->pdfBase64 = base64_encode(file_get_contents($this->fileLink));
        }
        elseif(isset($this->routeName)) {
            /**
             * Si esta seteado el routeName se consulta la ruta, y se obtiene el base64
             */
            $url = route($this->routeName, $this->routeParams);

            /**
             * Si esta en local, remplaza el https por http
             */
            if(env('APP_ENV') == 'local')
            {
                $url = Str::replace('https', 'http', $url);
            }

            $response = Http::get($url);

            $content = $response->getBody();

            $this->pdfBase64 = chunk_split(base64_encode($content));
        }
        elseif(isset($this->view))
        {
            /**
             * Si esta seteado el view, se carga la vista y se obtiene el base64
             */
            $documentFile = \PDF::loadView($this->view, $this->viewData);
            $this->pdfBase64 = base64_encode($documentFile->output());
        }

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
         * Solicitud http a la api para firmar
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
        $file = $this->filename.".pdf";
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

<?php

namespace App\Livewire\Sign;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use App\Services\ImageService;
use App\Models\Documents\Sign\Signature;
use App\Traits\SingleSignature;

class SignToDocument extends Component
{
    use SingleSignature;

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
     *       'callbackRoute' => 'finance.dtes.confirmation.store',
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

    public $callbackRoute;
    public $callbackParams;

    public $dispatchEvent;
    public $dispatchParams;

    public $callbackControllerMethods;
    public $callbackControllerParams;

    public $message;

    public function render()
    {
        return view('livewire.sign.sign-to-document');
    }

    /**
     * Muestra el modal
     *
     * @return void
     */
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
            $show_controller_method = Route::getRoutes()->getByName($this->routeName)->getActionName();
            $response = app()->call($show_controller_method, $this->routeParams);

            $this->pdfBase64 = base64_encode($response->original);
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

    /**
     * Cierra el model
     *
     * @return void
     */
    public function dismiss()
    {
        $this->showModal = null;
    }

    /**
     * Firma un archivo
     *
     * @return void
     */
    public function signDocument()
    {
        // $this->signFile($this->signer, $this->position, $this->row, $this->startY, $this->pdfBase64, $this->otp, $this->filename);

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

        $this->message = null;

        /**
         * Verifica si existe un error
         */
        if (array_key_exists('error', $json))
        {
            $this->message = $json['error'];
        }
        elseif(!array_key_exists('content', $json['files'][0]))
        {
            if (array_key_exists('error', $json))
            {
                $this->message = $json['error'];
            }
            else
            {
                $this->message = $json['files'][0]['status'];
            }
        }

        /**
         * Muestra el mensaje de error
         */
        if(isset($this->message))
        {
            return;
        }

        if(isset($json['files'][0]))
        {
            /**
             * Obtiene el archivo, la carpeta y el nombre del archivo
             */
            $file = $this->filename.".pdf";
            $contentFile = base64_decode($json['files'][0]['content']);

            /**
             * Guarda el archivo en el storage
             */
            Storage::put($file, $contentFile, ['CacheControl' => 'no-store']);

            /**
             * Redirige a la route, definida en callbackRoute
             */
            if(isset($this->callbackRoute)) {
                return redirect()->route($this->callbackRoute, $this->callbackParams);
            }

            /**
             * Ejecuta dispatch, definido en callbackControllerMethods y emit al dispatchEvent
             */

            /*
            No Se usa

            if(isset($this->dispatchEvent) && isset($this->callbackControllerMethods)) {
                app()->call($this->callbackControllerMethods,
                json_decode($this->callbackControllerParams, true));

                $this->dispatch($this->dispatchEvent, $this->dispatchParams);
            }
            */

            /**
             * Setea los inputs
             */
            $this->resetInputs();
        }
    }

    /**
     * Resetea los inputs
     *
     * @return void
     */
    public function resetInputs()
    {
        $this->showModal = null;
        $this->otp;
    }
}

<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\Signature;
use App\Services\DocumentSignService;
use App\Services\ImageService;
use App\User;
use Livewire\Component;

class SignatureTest extends Component
{
    public $dump;
    public $otp;
    public $message;
    public $type_message;

    /**
     * How to use
     *
     * @livewire('sign.signature-test')
     */

    public function render()
    {
        return view('livewire.sign.signature-test');
    }

    public function sign()
    {
        /**
         * Setea el user
         */
        $user = auth()->user();

        /**
         * Setea el base64Image
         */
        $base64Image = app(ImageService::class)->createSignature($user);

        /**
         * Setea el base64 del pdf
         */
        $documentBase64Pdf = base64_encode(file_get_contents(public_path('samples/sample.pdf')));

        /**
         * Calculate el eje X
         */
        $coordinateX = app(Signature::class)->calculateColumn('center');

        /**
         * Calculate el eje X
         */
        $coordinateY = app(Signature::class)->calculateRow(1, 60);

        /**
         * Firma el documento con el servicio DocumentSignService
         */
        try {
            $documentSignService = new DocumentSignService;
            $documentSignService->setDocument($documentBase64Pdf);
            $documentSignService->setFolder('/ionline/sign/test/');
            $documentSignService->setFilename('test-signature-1');
            $documentSignService->setUser($user);
            $documentSignService->setXCoordinate($coordinateX);
            $documentSignService->setYCoordinate($coordinateY);
            $documentSignService->setBase64Image($base64Image);
            $documentSignService->setPage('LAST');
            $documentSignService->setOtp($this->otp);
            // $documentSignService->setEnvironment('TEST');
            $documentSignService->setModo('ATENDIDO');
            $documentSignService->sign();

            $this->message = "La firma fue realizada exitosamente.";
            $this->type_message = 'success';
        } catch (\Throwable $th) {
            $this->message = "Error ".$th->getCode() .", ". $th->getMessage();
            $this->type_message = 'danger';
        }

    }
}

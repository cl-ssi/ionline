<?php

namespace App\Jobs;

use App\Models\Documents\Sign\Signature;
use App\Models\Finance\Dte;
use App\Services\DocumentSignService;
use App\Services\ImageService;
use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SignDteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    public $user_id;

    /**
     * @var mixed
     */
    public $dte_id;

    /**
     * @var string
     */
    public $otp;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $user_id
     * @param  mixed  $dte_id
     * @param  string  $otp
     * @return void
     */
    public function __construct($user_id, $dte_id, string $otp)
    {
        $this->user_id = $user_id;
        $this->dte_id = $dte_id;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            /**
             * Setea el user
             */
            $user = User::find($this->user_id);

            /**
             * Setea el base64Image
             */
            $base64Image = app(ImageService::class)->createSignature($user);

            /**
             * Obtiene el DTE dado el dteId
             */
            $dte = Dte::find($this->dte_id);

            /**
             * Determina si es farmaceutico
             */
            $isPharmacist = $dte->pharmacist->id == $this->user_id;

            /**
             * Determina si es el jefe
             */
            $isBoss = $dte->boss->id == $this->user_id;

            /**
             * Bloque el DTE
             */
            $dte->update([
                'block_signature' => true,
            ]);

            /**
             *  Obtiene la url del archivo a firmar
             */
            $fileToSign = ($isPharmacist) ? $dte->confirmation_signature_file_url : $dte->cenabast_reception_file_url;

            /**
             * Parsing link confirmation_signature_file_url a base64
             */
            $documentBase64Pdf = base64_encode(file_get_contents($fileToSign));

            /**
             * Calculate el eje X
             */
            $coordinateX = app(Signature::class)->calculateColumn($isPharmacist ? 'left' : 'right');

            /**
             * Calculate el eje X
             */
            $coordinateY = app(Signature::class)->calculateRow(1, 60);

            /**
             * Firma el documento con el servicio DocumentSignService
             */
            $documentSignService = new DocumentSignService;
            $documentSignService->setDocument($documentBase64Pdf);
            $documentSignService->setFolder('/ionline/cenabast/signature/');
            $documentSignService->setFilename('dte-' . $dte->id);
            $documentSignService->setUser($user);
            $documentSignService->setXCoordinate($coordinateX);
            $documentSignService->setYCoordinate($coordinateY);
            $documentSignService->setBase64Image($base64Image);
            $documentSignService->setPage('LAST');
            $documentSignService->setOtp($this->otp);
            $documentSignService->setModo('ATENDIDO');
            $documentSignService->sign();

            /**
             * Si es farmaceutico, setea que ya firmo
             */
            if($isPharmacist == true)
            {
                $dte->update([
                    'cenabast_signed_pharmacist' => true,
                ]);
            }

            /**
             * Si es el jefe, setea que ya firmo
             */
            if($isBoss)
            {
                $dte->update([
                    'cenabast_signed_boss' => true,
                ]);
            }

            if(! isset($dte->cenabast_reception_file))
            {
                /**
                 * Setea el campo con la ruta del archivo firmado
                 */
                $dte->update([
                    'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id.'.pdf' ,
                ]);
            }
        } catch (Exception $e) {
            /**
             * Si se produce un error, se elimina el job.
             * No tiene sentido dejar el job en fallidos porque el OTP ya vencio.-//
             */
            $this->failed($e);

            /**
             * Desbloque el DTE
             */
            $dte->update([
                'block_signature' => false,
            ]);
        }
    }

    public function failed($exception)
    {
        $this->delete();
    }
}

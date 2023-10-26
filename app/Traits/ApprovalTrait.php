<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Traits\SingleSignature;
use App\Models\Documents\Approval;
use App\Jobs\ProcessApproval;

trait ApprovalTrait
{
    /**
     * @param  Approval  $approval
     * @return void
     */
    public function show(Approval $approval)
    {
        /**
         * Muestra el modal
         */
        $this->showModal = 'd-block';
        $this->approvalSelected = $approval;
        $this->reject_observation = null;
        $this->otp = null;
        $this->message = null;
    }

    /**
     * Funcion para al cerrar el modal
     *
     * @return void
     */
    public function dismiss()
    {
        $this->showModal = null;
    }

    /**
     * Approve or reject
     *
     * @param  Approval  $approvalSelected
     * @param  bool  $status
     * @return void
     */
    public function approveOrReject(Approval $approvalSelected, bool $status)
    {
        /**
         * Guardar los datos del aprobacion o rechazo
         */
        $approvalSelected->approver_ou_id = $approvalSelected->approver_ou_id ?? auth()->user()->organizational_unit_id;
        $approvalSelected->approver_id = auth()->id();
        $approvalSelected->approver_at = now();
        $approvalSelected->status = $status;
        $approvalSelected->reject_observation = $this->reject_observation;
        $approvalSelected->save();

        /**
         * Si el approval es de tipo firma digital y fue aprobado
         */
        if($approvalSelected->digital_signature && $status == true) {
            /*
             * Consulto el archivo desde la ruta y obtengo el base64
             */
            $show_controller_method = Route::getRoutes()->getByName($approvalSelected->document_route_name)->getActionName();
            $response = app()->call($show_controller_method, json_decode($approvalSelected->document_route_params, true));
            $pdfBase64 = base64_encode($response->original);

            /**
             * Firmo el archivo con el trait
             */
            try {
                $this->signFile(auth()->user(), $this->position, $row = 1, $this->start_y, $pdfBase64, $this->otp, $approvalSelected->filename);
            } catch (\Throwable $th) {
                $this->message = $th->getMessage();
                return;
            }
        }

        /**
         * Si viene un nombre de archivo y no es de firma electrónica, generar el pdf y guardar en storage
         */
        if ($approvalSelected->filename AND !$approvalSelected->digital_signature) {
            /**
             * Obtiene el archivo desde el controller y sus parametros y genera el PDF
             */
            $show_controller_method = Route::getRoutes()->getByName($approvalSelected->document_route_name)->getActionName();
            $response = app()->call($show_controller_method, json_decode($approvalSelected->document_route_params, true));

            /**
             * Guarda el archivo en el storage
             */
            Storage::disk('gcs')->put($approvalSelected->filename, $response->original, ['CacheControl' => 'no-store']);
        }

        /*
         * Si tiene un callback, se ejecuta en cola
         */
        if($approvalSelected->callback_controller_method) {
            ProcessApproval::dispatch($approvalSelected);
        }

        /**
         * Cierra el modal
         */
        $this->dismiss();

        /**
         * Si se especificó una ruta de redirección, entones luego de aprobaro o rechazar
         * se redirecionará a la ruta
         */
        if($this->redirect_route){
            return redirect()->route($this->redirect_route);
        }
 
    }

}
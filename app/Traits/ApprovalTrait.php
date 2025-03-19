<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Models\Documents\DigitalSignature;
use App\Models\Documents\Approval;
use App\Jobs\ProcessApproval;
use App\Models\Rrhh\Authority;

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

        /**
         * Resetear siempre a false para aprobaciones individuales
         */
        $this->bulk = false;

        /** Soy manager de alguna OU hoy? */
        $ous = auth()->user()->amIAuthorityFromOu->pluck('organizational_unit_id')->toArray();
        $ous = in_array('1', auth()->user()->IamSecretaryOf->pluck('organizational_unit_id')->toArray()) ? array_merge($ous, [1]) : $ous;

        /** Mostrar sólo approvals activos */
        if($approval->active ) {
            /** Mostrar sólo approvals que me pertenecen */
            if( auth()->id() == $approval->sent_to_user_id OR in_array($approval->sent_to_ou_id, $ous)) {
                $this->approvalSelected = $approval;
                $this->approver_observation = null;
                $this->otp = null;
                $this->message = null;
            }
            else {
                session()->flash('danger','La aprobación no le pertenece');
                $this->dismiss();
            }
        }
        else {
            session()->flash('danger','La aprobación está inactiva');
            $this->dismiss();
        }
    }

    /**
     * Funcion para al cerrar el modal
     *
     * @return void
     */
    public function dismiss()
    {
        $this->showModal = null;

        /**
         * Resetear siempre a false
         */
        $this->bulk = false;
    }

    /**
     * Approve or reject
     *
     * @param  array $approvals_ids
     * @param  bool  $status
     * @return void
     */
    public function approveOrReject($approval_ids, bool $status)
    {
        /**
         * ================================================ 
         * RECHAZAR: Tratar todas como aprobaciones simples
         * ================================================
         **/
        if($status == false) {
            $approvals = Approval::whereIn('id',$approval_ids)->get();

            foreach($approvals as $approval) {
                $this->singleApprovation($approval, $status);
                /**
                 * Si viene un nombre de archivo, generar el pdf y guardar en storage
                 */
                if ($approval->filename) {
                    $this->storeFile($approval);
                }
                /**
                 * Si tiene un callback, se ejecuta en cola
                 */
                if($approval->callback_controller_method OR $approval->approvable_callback) {
                    ProcessApproval::dispatch($approval);
                }
            }
        }
        /**
         * ================================================ 
         * APROBAR, evaluar ambas: aprobaciones simples y firma digital
         * ================================================
         **/
        else {
            /**
             * ================================== 
             * Aprobar: Aprobaciones simples 
             * ================================== 
             **/
            $approvalsSimples = Approval::whereIn('id',$approval_ids)
                ->where('digital_signature', false)
                ->get();

            if( $approvalsSimples->isNotEmpty() ) {
                foreach($approvalsSimples as $approval) {
                    $this->singleApprovation($approval, $status);
                    /**
                     * Si viene un nombre de archivo, generar el pdf y guardar en storage
                     */
                    if ($approval->filename) {
                        $this->storeFile($approval);
                    }
                    /**
                     * Si tiene un callback, se ejecuta en cola
                     */
                    if($approval->callback_controller_method OR $approval->approvable_callback) {
                        ProcessApproval::dispatch($approval);
                    }
                }
            }


            /** 
             * ===========================================
             * Aprobar: Firmar con firma digital
             * ===========================================
             */

            $approvalsSignatures = Approval::whereIn('id',$approval_ids)->where('digital_signature', true)->get();

            if( $approvalsSignatures->isNotEmpty() ) {
                foreach($approvalsSignatures as $approval) {
                    /**
                     * Obtiene el archivo desde el controller con sus parametros y genera el PDF
                     */
                    if($approval->document_pdf_path) {
                        // METODO get() obtiene el contenido.
                        $response = Storage::get($approval->document_pdf_path);

                        $files[] = $response;
                    }
                    else {
                        $show_controller_method = Route::getRoutes()->getByName($approval->document_route_name)->getActionName();
                        $response = app()->call($show_controller_method, json_decode($approval->document_route_params, true));

                        $files[] = $response->original;
                    }
 
                    $positions[] = [  // Opcional
                        'column'        => $approval->position,     // 'left','center','right'
                        'row'           => 'first',                 // 'first','second'
                        'margin-bottom' => $approval->start_y ?? 0, // 0 pixeles
                    ];
                }
                $digitalSignature = new DigitalSignature();
                $success = $digitalSignature->signature(auth()->user(), $this->otp, $files, $positions);

                if($success) {
                    foreach($digitalSignature->response['files'] as $key => $file) {
                        if($file['status'] == 'OK') {
                            $store = $digitalSignature->storeSignedFile($key, $approvalsSignatures[$key]->filename);
                            $this->singleApprovation($approvalsSignatures[$key], $status);
                            /**
                             * Si tiene un callback, se ejecuta en cola
                             */
                            if($approval->callback_controller_method OR $approval->approvable_callback) {
                                ProcessApproval::dispatch($approvalsSignatures[$key]);
                            }
                        }
                    }
                }
                else {
                    $this->message = $digitalSignature->error;
                    return;
                }
            }
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
            return redirect()->route($this->redirect_route, $this->redirect_parameter);
        }
    }

    function singleApprovation($approval, $status) {
        /**
         * Guardar los datos del aprobacion o rechazo
         */
        $approval->approver_ou_id = $approval->sent_to_ou_id ?? auth()->user()->organizational_unit_id;
        $approval->approver_id = auth()->id();
        $approval->approver_observation = $this->approver_observation;
        $approval->approver_at = now();
        $approval->status = $status;

        /**
         * Si no fue firma en masa, y el approval tiene callback_feedback_inputs
         */
        if($this->bulk == false AND $approval->callback_feedback_inputs) {
            /**
             * Añade los feedback inputs al final de array de parametros del callback
             */
            $inputs = json_decode($approval->callback_feedback_inputs,true);
            foreach($inputs as $key => $input) {
                $inputs[$key]['value'] = $this->callback_feedback_inputs[$input['name']];
            }
            $approval->callback_feedback_inputs = json_encode($inputs);
        }

        $approval->save();
    }

    function storeFile($approval) {
        /**
         * Obtiene el archivo desde el controller y sus parametros y genera el PDF
         */
        $show_controller_method = Route::getRoutes()->getByName($approval->document_route_name)->getActionName();
        $response = app()->call($show_controller_method, json_decode($approval->document_route_params, true));

        /**
         * Guarda el archivo en el storage
         */
        Storage::put($approval->filename, $response->original, ['CacheControl' => 'no-store']);
    }

}
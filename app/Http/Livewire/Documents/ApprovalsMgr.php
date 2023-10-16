<?php

namespace App\Http\Livewire\Documents;

use App\Models\Documents\Approval;
use App\Jobs\ProcessApproval;
use App\Traits\SingleSignature;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ApprovalsMgr extends Component
{
    use SingleSignature;

    public $showModal = false;
    public $reject_observation;
    public $approvalSelected;
    public $ids = [];
    public $filter = [];
    public $otp;
    public $message;

    /**
     * @param  Approval  $approval
     * @return void
     */
    public function mount(Approval $approval)
    {
        /**
         * Si se pasa un modelo por parametro, se carga la hoja con el modal abierto
         */
        if($approval->exists) {
            $this->show($approval);
        }
        $this->filter['status'] = '';
    }

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
                $this->signFile(auth()->user(), 'center', 1, 80, $pdfBase64, $this->otp, $approvalSelected->filename);
            } catch (\Throwable $th) {
                $this->message = $th->getMessage();
                return;
            }
        }

        /**
         * Guardar los datos del aprobacion o rechazo
         */
        $approvalSelected->approver_ou_id = auth()->user()->organizational_unit_id;
        $approvalSelected->approver_id = auth()->id();
        $approvalSelected->approver_at = now();
        $approvalSelected->status = $status;
        $approvalSelected->reject_observation = $this->reject_observation;
        $approvalSelected->save();

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
    }

    /**
     * Bulk Process
     *
     * @param  bool  $status
     * @return void
     */
    public function bulkProcess($status)
    {
        foreach($this->ids as $id => $value) {
            $approvalSelected = Approval::find($id);
            $this->approveOrReject($approvalSelected, $status);
        }
        $this->ids = [];
    }

    /**
     * Obtiene los approvals
     *
     * @return void
     */
    public function getApprovals()
    {
        /** Soy manager de alguna OU hoy? */
        $ous = auth()->user()->amIAuthorityFromOu->pluck('organizational_unit_id')->toArray();

        $query = Approval::query();

        /** Sólo mostrar los activos */
        $query->whereActive(true);

        /** Filtrar los que son dirigidos a mi lista de ous o mi persona */
        $query->where(function ($query) use($ous) {
            $query->whereIn('approver_ou_id',$ous)
                  ->orWhere('approver_id',auth()->id());
        });

        /** Filtro */
        switch($this->filter['status']) {
            case "0": $query->where('status',false); break;
            case "1": $query->where('status',true); break;
            case "?": $query->whereNull('status'); break;
        }

        return $query->latest()->paginate(100);
    }

    /**
     * @return \Illuminate\Contracts\Support\Arrayable|array
     */
    public function render()
    {
        $approvals = $this->getApprovals();

        return view('livewire.documents.approvals-mgr', [
            'approvals' => $approvals,
        ])->extends('layouts.bt4.app');
    }
}

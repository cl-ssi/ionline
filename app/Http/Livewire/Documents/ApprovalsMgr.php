<?php

namespace App\Http\Livewire\Documents;

use App\Models\Documents\Approval;
use App\Jobs\ProcessApproval;
use Livewire\Component;

class ApprovalsMgr extends Component
{
    public $showModal = false;
    public $reject_observation;
    public $approvalSelected;
    public $ids = [];
    public $filter = [];

    /**
     * @param  Approval $approval
     * @return void
     */
    public function mount(Approval $approval)
    {
        /** Si se pasa un modelo por parametro, se carga la hoja con el modal abierto */
        if($approval->exists) {
            $this->show($approval);
        }
        $this->filter['status'] = '';
    }

    /**
     * @param  Approval $approval
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
    }

    public function dismiss()
    {
        /** Codigo al cerrar el modal */
        $this->showModal = null;
    }

    /**
     * Approve or reject
     *
     * @param  Approval $approvalSelected
     * @param  bool $status
     * @return void
     */
    public function approveOrReject(Approval $approvalSelected, bool $status)
    {
        $approvalSelected->approver_id = auth()->id();
        $approvalSelected->approver_at = now();
        $approvalSelected->status = $status;
        $approvalSelected->reject_observation = $this->reject_observation;
        $approvalSelected->save();

        /** Si tiene un callback, se ejecuta en cola */
        if($approvalSelected->callback_controller_method) {
            ProcessApproval::dispatch($approvalSelected);
        }

        $this->dismiss();
    }

    /**
     * Bulk Approvation
     *
     * @param  bool $status
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
        ]);
    }
}

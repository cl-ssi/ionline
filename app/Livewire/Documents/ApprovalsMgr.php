<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use App\Traits\SingleSignature;
use App\Traits\ApprovalTrait;
use App\Models\Documents\Approval;
use Livewire\WithPagination;

class ApprovalsMgr extends Component
{
    use SingleSignature;
    use ApprovalTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $approver_observation;
    public $approvalSelected;
    public $ids = [];
    public $bulk = false;
    public $filter = [];
    public $otp;
    public $message;
    public $callback_feedback_inputs = [];
    public $modules = [];

    /** Utilizada por el approval-button */
    public $redirect_route;
    public $redirect_parameter;

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
        $this->filter['module'] = '';
        $this->modules = Approval::groupBy('module')->pluck('module');
    }

    /**
     * Bulk Process
     *
     * @param  bool  $status
     * @return void
     */
    public function bulkProcess($status)
    {
        $this->bulk = true;
        $this->approveOrReject(array_keys($this->ids), $status);
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
            $query->whereIn('sent_to_ou_id',$ous)
                  ->orWhere('sent_to_user_id',auth()->id());
        });

        /** Filtro */
        switch($this->filter['status']) {
            case "0": $query->where('status',false); break;
            case "1": $query->where('status',true); break;
            case "?": $query->whereNull('status'); break;
        }

        if($this->filter['module']) {
            $query->where('module',$this->filter['module']);
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

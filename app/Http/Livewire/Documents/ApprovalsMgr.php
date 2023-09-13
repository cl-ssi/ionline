<?php

namespace App\Http\Livewire\Documents;

use Livewire\Component;
use App\Models\Documents\Approval;
use App\Jobs\ProcessApproval;

class ApprovalsMgr extends Component
{
    public $reject_observation;

    /**
    * Approve or reject
    */
    public function approveOrReject(Approval $approval, $status)
    {
        $approval->approver_id = auth()->id();
        $approval->approver_at = now();
        $approval->status = $status;
        $approval->reject_observation = $this->reject_observation;
        $approval->save();

        /** Si tiene un callback, se ejecuta en cola */
        if($approval->callback_controller_method) {
            ProcessApproval::dispatch($approval);
        }
    }

    public function render()
    {
        $approvals = Approval::all();
        return view('livewire.documents.approvals-mgr', [
            'approvals'=>$approvals,
        ]);
    }
}

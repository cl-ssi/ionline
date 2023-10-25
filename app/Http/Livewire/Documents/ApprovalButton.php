<?php

namespace App\Http\Livewire\Documents;

use Livewire\Component;
use App\Traits\ApprovalTrait;
use App\Models\Documents\Approval;

class ApprovalButton extends Component
{
    use ApprovalTrait;

    public Approval $approval;

    public $showModal = false;
    public $reject_observation;
    public $approvalSelected;
    public $otp;
    public $message;

    public function render()
    {
        return view('livewire.documents.approval-button');
    }
}

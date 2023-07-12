<?php

namespace App\Http\Livewire\ServiceRequests;

use Livewire\Component;

class ApprovalWorkflow extends Component
{

    public $serviceRequest;

    public function mount($serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }


    public function render()
    {
        return view('livewire.service-requests.approval-workflow');
    }
}

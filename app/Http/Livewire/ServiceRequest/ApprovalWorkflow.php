<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\SignatureFlow;
use Illuminate\Support\Facades\Session;

class ApprovalWorkflow extends Component
{

    public $serviceRequest;
    public $signatureFlowId;

    public $status;
    public $observation;

    public function mount($serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    public function render()
    {
        return view('livewire.service-request.approval-workflow');
    } 


    public function saveSignatureFlow($signatureFlowId)
    {
        $signatureFlow = SignatureFlow::find($signatureFlowId);
        $signatureFlow->status = $this->status;
        $signatureFlow->observation = $this->observation;
        $signatureFlow->signature_date = now();
        $signatureFlow->save();
        Session::flash('message', 'La firma se ha guardado correctamente.');


        $this->render();


    }
}

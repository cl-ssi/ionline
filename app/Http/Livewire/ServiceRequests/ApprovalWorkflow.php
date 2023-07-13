<?php

namespace App\Http\Livewire\ServiceRequests;

use Livewire\Component;
use App\Models\ServiceRequests\SignatureFlow;
use Illuminate\Support\Facades\Session;

class ApprovalWorkflow extends Component
{

    public $serviceRequest;
    public $signatureFlowId;

    public function mount($serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    public function render()
    {
        return view('livewire.service-requests.approval-workflow');
    }

    public function updateStatus($signatureFlowId, $status)
    {
        $signatureFlow = SignatureFlow::find($signatureFlowId);
        $signatureFlow->status = $status;        
        $signatureFlow->user_id = $this->serviceRequest->responsable_id;
        $signatureFlow->signature_date = now();
        $signatureFlow->save();

        Session::flash('message', 'El estado se ha actualizado correctamente.');
        $this->render();
    }

    public function updateObservation($signatureFlowId, $observation)
    {
        $signatureFlow = SignatureFlow::find($signatureFlowId);
        $signatureFlow->observation = $observation;
        $signatureFlow->save();

        Session::flash('message', 'La observación se ha actualizado correctamente.');
    }

}

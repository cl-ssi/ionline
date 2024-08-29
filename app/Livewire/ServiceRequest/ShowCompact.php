<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class ShowCompact extends Component
{
    public ServiceRequest $serviceRequest;

    public function deleteRequest(ServiceRequest $serviceRequest){
        // dd($serviceRequest->user_id);
        $serviceRequest->delete();
        session()->flash('success', 'Se eliminó la solicitud.');
        return redirect()->route('rrhh.service-request.show',['user' => $serviceRequest->user_id]);
    }
    
    public function render()
    {
        return view('livewire.service-request.show-compact');
    }
}

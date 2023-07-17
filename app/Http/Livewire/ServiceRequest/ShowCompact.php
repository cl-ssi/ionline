<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;

class ShowCompact extends Component
{
    public ServiceRequest $serviceRequest;
    
    public function render()
    {
        return view('livewire.service-request.show-compact');
    }
}

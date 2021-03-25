<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Models\ServiceRequests\ServiceRequest;
use Livewire\Component;

class PendingServiceRequest extends Component
{
    public $data;

    public function render()
    {
        return view('livewire.service-request.pending-service-request');
    }
}

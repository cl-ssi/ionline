<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\Fulfillment;

class PeriodRrhh extends Component
{
    public Fulfillment $fulfillment;

    public function render()
    {
        return view('livewire.service-request.period-rrhh');
    }
}

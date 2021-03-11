<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class ShowTotalHours extends Component
{
    public $serviceRequest;



    public function render()
    {
        return view('livewire.service-request.show-total-hours')
            ->withServiceRequest($this->serviceRequest);
    }
}

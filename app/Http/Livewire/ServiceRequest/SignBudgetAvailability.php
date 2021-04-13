<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class SignBudgetAvailability extends Component
{
    public $serviceRequest;

    public function render()
    {
        return view('livewire.service-request.sign-budget-availability');
    }
}

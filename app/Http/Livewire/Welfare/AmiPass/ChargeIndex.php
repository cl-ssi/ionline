<?php

namespace App\Http\Livewire\Welfare\Amipass;

use App\Models\Welfare\Amipass\Charge;
use App\Models\Welfare\Amipass\NewCharge;
use App\Models\Welfare\Amipass\Regularization;
use Livewire\Component;

class ChargeIndex extends Component
{
    public function render()
    {
        return view('livewire.welfare.amipass.charge-index', [
            'records' => Charge::where('rut', auth()->id())->get(),
            'regularizations' => Regularization::where('rut', auth()->id())->get(),
            'new_records' => NewCharge::where('rut', auth()->id())->get()
        ]);
    }
}

<?php

namespace App\Http\Livewire\Welfare\Amipass;

use App\Models\Welfare\AmiPass\Charge;
use Livewire\Component;

class ChargeIndex extends Component
{
    public function render()
    {
        return view('livewire.welfare.amipass.charge-index', [
            'records' => Charge::where('rut', auth()->id())
                ->paginate(50),
        ]);
    }
}

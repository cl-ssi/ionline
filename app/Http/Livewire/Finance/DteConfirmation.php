<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use App\Models\Finance\Dte;

class DteConfirmation extends Component
{
    public $dte;
    public $confirmation_observation;

    /**
     * Mount
     */
    public function mount(Dte $dte)
    {
        $this->dte = $dte;
    }

    public function render()
    {
        return view('livewire.finance.dte-confirmation');
    }

    public function rejectedDte()
    {
        $this->dte->update([
            'confirmation_status' => 0,
            'confirmation_user_id' => auth()->id(),
            'confirmation_ou_id' => auth()->user()->organizational_unit_id,
            'confirmation_observation' => $this->confirmation_observation,
            'confirmation_at' => now(),
        ]);

        session()->flash('success', 'El DTE fue rechazado.');
    }
}

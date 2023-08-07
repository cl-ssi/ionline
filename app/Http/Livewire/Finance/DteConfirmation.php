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
        // $this->dte->fresh();
        // $this->dte->requestForm->contractManager;
        return view('livewire.finance.dte-confirmation');
    }
}

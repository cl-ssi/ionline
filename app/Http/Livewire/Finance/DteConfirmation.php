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

    /**
    * Confirmation
    */
    public function saveConfirmation($status)
    {
        $this->dte->confirmation_status = $status;
        $this->dte->confirmation_user_id = auth()->id();
        $this->dte->confirmation_ou_id = auth()->user()->organizational_unit_id;
        $this->dte->confirmation_observation = $this->confirmation_observation;
        $this->dte->confirmation_at = now();
        $this->dte->save();

    }
    
    public function render()
    {
        // $this->dte->fresh();
        // $this->dte->requestForm->contractManager;
        return view('livewire.finance.dte-confirmation');
    }
}

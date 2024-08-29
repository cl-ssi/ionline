<?php

namespace App\Livewire\Finance;

use App\Models\Finance\Dte;
use Livewire\Component;

class CheckTesoreria extends Component
{
    public $dte;

    public function checkTesoreria() {
        $this->dte->update([
            'check_tesoreria' => true
        ]);
    }
    
    public function render()
    {
        return view('livewire.finance.check-tesoreria');
    }
}

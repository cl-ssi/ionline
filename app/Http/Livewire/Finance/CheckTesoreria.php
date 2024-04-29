<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Dte;
use Livewire\Component;

class CheckTesoreria extends Component
{
    public $dte_id;

    public function checkTesoreria($dte_id) {
        $dte = Dte::find($dte_id);
        $dte->update([
            'check_tesoreria' => true
        ]);
    }
    public function render()
    {
        return view('livewire.finance.check-tesoreria');
    }
}

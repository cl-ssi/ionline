<?php

namespace App\Livewire\Finance\FixedFund;

use App\Models\Finance\FixedFund;
use Livewire\Component;

class IndexFixedFund extends Component
{
    public $fixedFunds;

    public function mount()
    {
        $this->fixedFunds = FixedFund::all();
    }

    public function render()
    {
        return view('livewire.finance.fixed-fund.index-fixed-fund');
    }
}

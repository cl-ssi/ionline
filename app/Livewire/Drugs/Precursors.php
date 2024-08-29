<?php

namespace App\Livewire\Drugs;

use Livewire\Component;
use App\Models\Drugs\ReceptionItem;

class Precursors extends Component
{
    public $precursors;

    /**
    * mount
    */
    public function mount()
    {
        $this->precursors = ReceptionItem::whereNotNull('dispose_precursor')->get();
    }

    public function render()
    {
        return view('livewire.drugs.precursors');
    }
}

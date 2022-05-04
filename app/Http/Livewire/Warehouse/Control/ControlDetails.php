<?php

namespace App\Http\Livewire\Warehouse\Control;

use Livewire\Component;

class ControlDetails extends Component
{
    public $control;

    public function render()
    {
        return view('livewire.warehouse.control.control-details');
    }
}

<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class TogglePrint extends Component
{
    public Inventory $inventory;
    public $color;

    /**
    * Toogle Print
    */
    public function toggle()
    {
        if(is_null($this->inventory->printed )) {
            $this->inventory->printed = true;
        }
        else if($this->inventory->printed == false) {
            $this->inventory->printed = null;
        }
        else {
            $this->inventory->printed = false;
        }
        $this->inventory->save();
    }

    public function render()
    {
        if(is_null($this->inventory->printed )) {
            $this->color = 'btn-primary';
        }
        else if($this->inventory->printed == false) {
            $this->color = 'btn-secondary';
        }
        else {
            $this->color = 'btn-success';
        }

        $this->inventory->printed_state = 'on';
        return view('livewire.inventory.toggle-print');
    }
}

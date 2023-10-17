<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class InventoryShow extends Component
{
    public $inventory;

    /**
    * Mount
    */
    public function mount($number)
    {
        $this->inventory = Inventory::where('number',$number)->first();
    }

    public function render()
    {
        if(is_null($this->inventory)) abort(404, "No existe el item");
        return view('livewire.inventory.inventory-show')->layout('layouts.bt4.inventory');
    }
}

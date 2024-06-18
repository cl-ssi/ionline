<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;

class InventorySheet extends Component
{

    public $place_id = null;
    public $inventories = [];
    public $place = null;


    protected $listeners = [
        'myPlaceId',
    ];

    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }



    public function render()
    {
        return view('livewire.inventory.inventory-sheet', [
            'inventories' => $this->inventories,
            'place' => $this->place,
        ]);
    }

    public function search()
    {
        //Inventory::where('place_id', $place->id)->get();
        $this->inventories = Inventory::where('place_id', $this->place_id)->get();
    
        $this->place = Place::find($this->place_id);
    }
    
}

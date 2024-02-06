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
        $this->inventories = [];
        $this->place = null;

        $inventories = Inventory::whereHas('lastConfirmedMovement', function ($query) {
            $query->where('reception_confirmation', true);
        })
        ->whereHas('lastConfirmedMovement.place', function ($query) {
            $query->where('place_id', $this->place_id);
        })->get();

        $this->inventories = $inventories; 
        $this->place = Place::find($this->place_id);
    }
}

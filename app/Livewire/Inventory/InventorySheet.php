<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;

class InventorySheet extends Component
{

    public $place_id = null;
    public $inventories = [];
    public $place = null;
    public $uniqueUsers = [];

    #[On('myPlaceId')] 
    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }

    public function mount()
    {
        $this->uniqueUsers = collect();
    }



    public function render()
    {
        return view('livewire.inventory.inventory-sheet', [
            'inventories' => $this->inventories,
            'place' => $this->place,
            'uniqueUsers' => $this->uniqueUsers,
        ]);
    }

    public function search()
    {
        
        $this->inventories = Inventory::where('place_id', $this->place_id)->get();    
        $this->place = Place::find($this->place_id);

        $users = collect();
        foreach ($this->inventories as $inventory) {
            if ($inventory->inventoryUsers) {
                foreach ($inventory->inventoryUsers as $inventoryuser) {
                    $users->push($inventoryuser->user);
                }
            }
        }
        $this->uniqueUsers = $users->unique('id');
    }
    
}

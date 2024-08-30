<?php

namespace App\Livewire\Inventory;

use App\Models\Inv\InventoryMovement;
use Livewire\Component;
use Livewire\Attributes\On; 

class UpdateMovement extends Component
{
    public $inventory;

    public function render()
    {
        return view('livewire.inventory.update-movement');
    }

    public function deleteMovement(InventoryMovement $movement)
    {
        $inventory = $movement->inventory;
        $movement->delete();

        if($inventory->lastMovement)
        {
            $inventory->update([
                'user_responsible_id' => $inventory->lastMovement->user_responsible_id,
                'place_id' => $inventory->lastMovement->place_id,
            ]);
        }


        $this->dispatch('updateMovementIndex');
        $this->onUpdateMovement();
    }

    #[On('updateMovement')] 
    public function onUpdateMovement()
    {
        $this->inventory->refresh();
    }
}

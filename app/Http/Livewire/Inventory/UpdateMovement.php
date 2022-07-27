<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\InventoryMovement;
use Livewire\Component;

class UpdateMovement extends Component
{
    public $inventory;

    protected $listeners = [
        'updateMovement' => 'onUpdateMovement'
    ];

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


        $this->emit('updateMovementIndex');
        $this->onUpdateMovement();
    }

    public function onUpdateMovement()
    {
        $this->inventory->refresh();
    }
}

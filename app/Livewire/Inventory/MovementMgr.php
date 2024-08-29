<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\InventoryMovement;


class MovementMgr extends Component
{
    public InventoryMovement $inventoryMovement;
    public $message = null;

    protected $rules = [
        'inventoryMovement.reception_confirmation' => 'required',
        'inventoryMovement.reception_date' => 'required|date:Y-m-d H:i:s',
    ];

    protected $messages = [
        'inventoryMovement.reception_confirmation.required' => 'La confirmacion de la recepción es requerida',
        'inventoryMovement.reception_date.required' => 'La fecha de recepción es requerida.',
    ];

    /**
    * Save
    */
    public function save()
    {
        $this->inventoryMovement->save();
        if ($this->inventoryMovement->reception_confirmation == 1)
        {
            $this->inventoryMovement->inventory->update(
                [
                    'user_responsible_id' => $this->inventoryMovement->user_responsible_id,
                    'user_using_id' => $this->inventoryMovement->user_using_id,
                    'place_id' => $this->inventoryMovement->place_id,
                    //'user_sender_id' => $this->inventoryMovement->user_sender_id
                ]
            );
        }
        $this->message = true;
    }
    

    public function render()
    {
        return view('livewire.inventory.movement-mgr');
    }
}

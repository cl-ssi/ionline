<?php

namespace App\Http\Livewire\Inventory;

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
        'inventoryMovement.reception_confirmation.required' => 'La fecha desde es requerida.',
        'inventoryMovement.reception_date.required' => 'El nombre es requerido.',
    ];

    /**
    * Save
    */
    public function save()
    {
        $this->inventoryMovement->save();
        $this->message = true;
    }

    public function render()
    {
        return view('livewire.inventory.movement-mgr');
    }
}

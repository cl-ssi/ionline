<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class RemovalRequestMgr extends Component
{

    public $showRemoved = false;
    public function render()
    {
        $inventories = $this->showRemoved
        ? Inventory::where('is_removed', true)->get()
        : Inventory::whereNotNull('removal_request_reason')->whereNull('is_removed')->get();
        return view('livewire.inventory.removal-request-mgr', [
            'inventories' => $inventories,
        ]);
        
    }

    public function approval($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);
        $inventory->is_removed = true;
        $inventory->removed_user_id = auth()->user()->id;
        $inventory->removed_at = now();
        $inventory->save();
        session()->flash('success', 'Solicitud enviada con éxito.');
        $this->render(); // Volver a renderizar la vista después de la aprobación
    }


    public function reject($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);

        $this->render(); // Volver a renderizar la vista después del rechazo
    }

}

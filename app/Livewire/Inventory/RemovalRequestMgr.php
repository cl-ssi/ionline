<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class RemovalRequestMgr extends Component
{
    public $showRemoved = false;
    public $showRejected = false;

    public function render()
    {
        $this->updateShowProperties();

        $inventories = $this->getInventories();

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
    }

    public function reject($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);
        $inventory->is_removed = false;
        $inventory->removed_user_id = auth()->user()->id;
        $inventory->removed_at = now();
        $inventory->save();
        session()->flash('success', 'Solicitud rechazada');
    }

    public function showRemoved()
    {
        $this->showRemoved = true;
        $this->showRejected = false;
    }
    
    public function showRejected()
    {
        $this->showRemoved = false;
        $this->showRejected = true;
    }
    

    private function updateShowProperties()
    {
        if ($this->showRemoved) {
            $this->showRejected = false;
        } elseif ($this->showRejected) {
            $this->showRemoved = false;
        }
        else {            
            $this->showRemoved = false;
            $this->showRejected = false;
        }
    }
    

    private function getInventories()
    {
        if ($this->showRemoved) {
            return Inventory::where('is_removed', true)->get();
        }

        if ($this->showRejected) {
            return Inventory::where('is_removed', false)->whereNotNull('removal_request_reason')->get();
        }

        return Inventory::whereNotNull('removal_request_reason')->whereNull('is_removed')->get();
    }
}


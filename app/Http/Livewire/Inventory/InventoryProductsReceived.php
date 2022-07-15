<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InventoryProductsReceived extends Component
{
    public function render()
    {
        return view('livewire.inventory.inventory-products-received', [
            'movements' => $this->getMovements(),
            'inventories' => $this->getInventories()
        ])->extends('layouts.app');
    }

    public function getMovements()
    {
        $movements = InventoryMovement::query()
            ->whereNull('reception_date')
            ->whereUserResponsibleId(Auth::id())
            ->orderBy('id')
            ->get();

        return $movements;
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->whereUserResponsibleId(Auth::id())
            ->get();

        return $inventories;
    }
}

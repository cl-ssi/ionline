<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryPending extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory.inventory-pending', [
            'inventories' => $this->getInventories()
        ])->extends('layouts.app');
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->whereNull('number')
            ->orderByDesc('id')
            ->paginate(10);

        return $inventories;
    }
}

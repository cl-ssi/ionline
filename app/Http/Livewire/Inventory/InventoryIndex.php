<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory.inventory-index',[
            'inventories' => $this->getInventories()
        ])->extends('layouts.app');
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->whereNotNull('number')
            ->orderBy('id')
            ->paginate(10);

        return $inventories;
    }
}

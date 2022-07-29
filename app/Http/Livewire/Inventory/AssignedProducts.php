<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AssignedProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory.assigned-products', [
            'inventories' => $this->getInventories()
        ])->extends('layouts.app');
    }

    public function getInventories()
    {
        $inventories = Inventory::query()
            ->whereUserResponsibleId(Auth::id())
            ->paginate(10);

        return $inventories;
    }
}

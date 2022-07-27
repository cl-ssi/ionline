<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        return view('livewire.inventory.inventory-index',[
            'inventories' => $this->getInventories()
        ])->extends('layouts.app');
    }

    public function getInventories()
    {
        $search = "%$this->search%";

        $inventories = Inventory::query()
            ->when($this->search, function($query) use($search){
                $query->where('number', 'like', $search)
                    ->orWhereHas('responsible', function($subquery) use($search){
                        $subquery->findByUser($this->search);
                    })
                    ->orWhereHas('place', function($subquery) use($search){
                        $subquery->where('name', 'like', $search)
                            ->orWhereHas('location', function($qu) use($search){
                                $qu->where('name', 'like', $search);
                            });
                    })->orWhereHas('product', function ($query) use($search){
                        $query->where('name', 'like', $search)
                            ->orWhereHas('product', function($subquery) use($search) {
                                $subquery->where('name', 'like', $search);
                            });
                    });
            })
            ->whereNotNull('number')
            ->orderBy('id')
            ->paginate(10);

        return $inventories;
    }
}

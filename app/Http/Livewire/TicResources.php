<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Inv\Inventory;
use Livewire\WithPagination;

class TicResources extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';
    public $type_resource;
    public $search;

    public function render()
    {
        return view('livewire.tic-resources', [
            'inventories' => $this->getInventories()
        ])->extends('layouts.bt4.app');
    }

    public function getInventories()
    {
        $search = "%$this->search%";

        $inventories = Inventory::query()
			->whereRelation('unspscProduct', 'code', '>=', '43000000')
			->whereRelation('unspscProduct', 'code', '<=', '44000000')
            ->doesntHave('computer')
            ->where(function($query) use($search) {
                $query->when($this->search, function($query) use($search) {
                    $query->where('number', 'like', $search)
                        ->orWhere('model', 'like', $search)
                        ->orWhere('brand', 'like', $search)
                        ->orWhere('serial_number', 'like', $search);
                });
            });


        if($this->type_resource != null)
        {
            $inventories = $inventories->get();
            if($this->type_resource == "for-merge")
                $ids = $inventories->where('have_computer', true)->pluck('id');
            else
                $ids = $inventories->where('have_computer', false)->pluck('id');

            $inventories = Inventory::whereIn('id', $ids)->paginate(10);
        }
        else
            $inventories = $inventories->paginate(10);

        return $inventories;
    }
}

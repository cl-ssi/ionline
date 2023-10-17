<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\Warehouse\TypeReception;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryPending extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;
    public $search;
    public $type_reception_id;

    public function render()
    {
        return view('livewire.inventory.inventory-pending', [
            'inventories' => $this->getInventories()
        ])->extends('layouts.bt4.app');
    }

    public function mount(Establishment $establishment)
    {
        //
    }

    public function getInventories()
    {
        $search = "%$this->search%";

        $inventories = Inventory::query()
            ->when($this->type_reception_id != '', function($query) {
                $query->whereHas('control', function ($query) {
                    $query->whereTypeReceptionId($this->type_reception_id);
                });
            })
            ->when($this->search, function ($query) use($search) {
                $query->when($this->type_reception_id == TypeReception::receiving(), function($query) use($search) {
                    $query->whereHas('control', function($query) use($search) {
                        $query->whereHas('origin', function($query) use($search) {
                            $query->where('name', 'like', $search);
                        });
                    });
                })
                ->when($this->type_reception_id == TypeReception::purchaseOrder(), function($query) use($search) {
                    $query->whereHas('control', function($query) use($search) {
                        $query->where('po_code', 'like', $search);
                    });
                })
                ->orWhereHas('product', function ($query) use($search) {
                    $query->where('name', 'like', $search)
                        ->orWhereHas('product', function($query) use($search) {
                            $query->where('name', 'like', $search)
                                ->orWhere('code', 'like', $search);
                        });
                });
            })
            ->whereEstablishmentId($this->establishment->id)
            ->whereNull('number')
            ->orderByDesc('id')
            ->paginate(5);

        return $inventories;
    }
}

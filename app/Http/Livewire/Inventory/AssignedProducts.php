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

    public $search;
    public $product_type;

    public function mount()
    {
        $this->product_type = '';
    }

    public function render()
    {
        return view('livewire.inventory.assigned-products', [
            'inventories' => $this->getInventories()
        ])->extends('layouts.bt4.app');
    }

    public function getInventories()
    {
        $search = "%$this->search%";

        $inventories = Inventory::query()
            ->when($this->product_type == 'using', function($query) {
                $query->whereUserUsingId(Auth::id());
            })
            ->when($this->product_type == 'responsible', function ($query) {
                $query->whereUserResponsibleId(Auth::id());
            })
            ->when($this->product_type == '', function($query) {
                $query->where(function($query) {
                    $query->where('user_responsible_id', Auth::id())
                      ->orWhere('user_using_id', Auth::id());
                });
            })
            ->when($this->search, function ($query)  use($search) {
                $query->where('number', 'like', $search);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return $inventories;
    }
}

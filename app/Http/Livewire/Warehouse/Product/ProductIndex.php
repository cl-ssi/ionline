<?php

namespace App\Http\Livewire\Warehouse\Product;

use App\Models\Warehouse\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $segment;
    public $family;
    public $class;
    public $search;

    public function render()
    {
        return view('livewire.warehouse.product.product-index', ['products' => $this->getProducts()]);
    }

    public function getProducts()
    {
        $search = "%$this->search%";
        return Product::query()
            ->whereClassId($this->class->id)
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->paginate(10);
    }
}

<?php

namespace App\Http\Livewire\Warehouse\Products;

use App\Models\Warehouse\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $store;
    public $search;

    public function render()
    {
        return view('livewire.warehouse.products.product-index', [
            'products' => $this->getProducts()
        ]);
    }

    public function getProducts()
    {
        $search = "%$this->search%";

        $products = Product::query()
            ->where('store_id', '=', $this->store->id)
            ->where('name', 'like', $search)
            ->when($this->search, function($q) use($search) {
                $q->orWhere(function($query) use($search) {
                    $query->whereHas('category', function ($subquery) use($search) {
                        $subquery->where('name', 'like', $search);
                    })
                    ->where('store_id', '=', $this->store->id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $products;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        $this->render();
    }
}

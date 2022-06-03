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
            ->when($this->search, function($q) use($search) {
                $q->where('name', 'like', $search);
            })
            ->whereStoreId($this->store->id)
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

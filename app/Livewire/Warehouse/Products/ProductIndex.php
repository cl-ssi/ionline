<?php

namespace App\Livewire\Warehouse\Products;

use App\Models\Warehouse\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $store;
    public $search;
    public $nav;

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
            ->where(function($query) use($search) {
                $query->when($this->search, function($subquery) use($search) {
                    $subquery->where('name', 'like', $search)
                        ->orWhere('barcode', 'like', $search)
                        ->orWhereHas('product', function($q) use($search) {
                            $q->where('code', 'like', $search)
                                ->orWhere('name', 'like', $search);
                        });
                });
            })
            ->whereStoreId($this->store->id)
            ->orderBy('created_at', 'desc')
            ->withTrashed()
            ->paginate(25);

        return $products;
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        $this->render();
    }
}

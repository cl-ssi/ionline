<?php

namespace App\Livewire\Warehouse\Products;

use App\Http\Requests\Warehouse\Product\CreateProductRequest;
use App\Models\Warehouse\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductCreate extends Component
{
    public $store;
    public $programs;
    public $categories;

    public $name;
    public $barcode;
    public $category_id;
    public $unspsc_product_id;
    public $search_unspsc_product;
    public $nav;

    public function rules()
    {
        return (new CreateProductRequest($this->store))->rules();
    }

    public function render()
    {
        return view('livewire.warehouse.products.product-create');
    }

    public function mount()
    {
        $this->categories = $this->store->categories;
    }

    public function createProduct()
    {
        $dataValidated = $this->validate();
        $dataValidated['store_id'] = $this->store->id;

        Product::create($dataValidated);
        return redirect()->route('warehouse.products.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }

    public function delete(Product $product)
    {
        $product->delete();
    }

    public function updatedSearchUnspscProduct()
    {
        $this->dispatch('searchProduct', $this->search_unspsc_product);
    }

    #[On('myProductId')]
    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }
}

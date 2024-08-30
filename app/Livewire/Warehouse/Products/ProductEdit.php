<?php

namespace App\Livewire\Warehouse\Products;

use App\Http\Requests\Warehouse\Product\EditProductRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductEdit extends Component
{
    public $store;
    public $categories;

    public $product;
    public $name;
    public $barcode;
    public $category_id;
    public $unspsc_product_id;
    public $search_unspsc_product;
    public $nav;

    public function rules()
    {
        return (new EditProductRequest($this->store, $this->product))->rules();
    }

    public function render()
    {
        return view('livewire.warehouse.products.product-edit');
    }

    public function mount()
    {
        $this->categories = $this->store->categories;

        $this->name = $this->product->name;
        $this->barcode = $this->product->barcode;
        $this->category_id = $this->product->category_id;
        $this->unspsc_product_id = $this->product->unspsc_product_id;
        $this->search_unspsc_product = $this->product->product->name;
    }

    #[On('myProductId')]
    public function myProductId($value)
    {
        $this->unspsc_product_id = $value;
    }

    public function updatedSearchUnspscProduct()
    {
        $this->unspsc_product_id = null;
        $this->dispatch('searchProduct', $this->search_unspsc_product);
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();
        $this->product->update($dataValidated);

        return redirect()->route('warehouse.products.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

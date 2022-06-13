<?php

namespace App\Http\Livewire\Warehouse\Products;

use App\Models\Warehouse\Category;
use App\Models\Warehouse\Product;
use App\Pharmacies\Program;
use Livewire\Component;

class ProductCreate extends Component
{
    public $store;
    public $programs;
    public $categories;
    public $name;
    public $category_id;

    public $rules = [
        'name'          => 'required|string|min:2|max:255',
        'category_id'   => 'nullable|exists:wre_categories,id',
    ];

    public function mount()
    {
        $this->categories = $this->store->categories;
    }

    public function render()
    {
        return view('livewire.warehouse.products.product-create');
    }

    public function createProduct()
    {
        $dataValidated = $this->validate();
        $dataValidated['store_id'] = $this->store->id;

        Product::create($dataValidated);
        return redirect()->route('warehouse.products.index', $this->store);
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}

<?php

namespace App\Http\Livewire\Warehouse\Product;

use Livewire\Component;

class ProductEdit extends Component
{
    public $segment;
    public $family;
    public $class;
    public $product;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->product->name;
    }

    public function render()
    {
        return view('livewire.warehouse.product.product-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->product->update($dataValidated);
        $this->product->refresh();
    }
}

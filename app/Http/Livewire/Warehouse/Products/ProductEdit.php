<?php

namespace App\Http\Livewire\Warehouse\Products;

use App\Models\Warehouse\Category;
use App\Pharmacies\Program;
use Livewire\Component;

class ProductEdit extends Component
{
    public $name;
    public $category_id;
    public $program_id;
    public $product;
    public $store;
    public $programs;
    public $categories;

    public $rules = [
        'name'          => 'required|string|min:2|max:255',
        'category_id'   => 'nullable|exists:wre_categories,id',
        'program_id'    => 'required|exists:frm_programs,id'
    ];

    public function mount()
    {
        $this->name = $this->product->name;
        $this->category_id = $this->product->category_id;
        $this->program_id = $this->product->program_id;

        $this->programs = Program::all();
        $this->categories = $this->store->categories;
    }

    public function render()
    {
        return view('livewire.warehouse.products.product-edit');
    }

    public function updateProduct()
    {
        $dataValidated = $this->validate();
        $this->product->update($dataValidated);

        return redirect()->route('warehouse.products.index', $this->store);
    }
}

<?php

namespace App\Livewire\Warehouse\Categories;

use App\Models\Warehouse\Category;
use Livewire\Component;

class CategoryEdit extends Component
{
    public $store;
    public $category;
    public $name;
    public $nav;

    public $rules = [
        'name' => 'required'
    ];

    public function mount()
    {
        $this->name = $this->category->name;
    }

    public function render()
    {
        return view('livewire.warehouse.categories.category-edit');
    }

    public function updateCategory()
    {
        $dataValidated = $this->validate();
        $this->category->update($dataValidated);

        return redirect()->route('warehouse.categories.index', ['store' => $this->store, 'nav' => $this->nav]);
    }
}

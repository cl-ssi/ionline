<?php

namespace App\Livewire\Warehouse\Categories;

use App\Models\Warehouse\Category;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $store;
    public $name;
    public $nav;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function render()
    {
        return view('livewire.warehouse.categories.category-create');
    }

    public function createCategory()
    {
        $dataValidated = $this->validate();
        $dataValidated['store_id'] = $this->store->id;
        Category::create($dataValidated);

        return redirect()->route('warehouse.categories.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

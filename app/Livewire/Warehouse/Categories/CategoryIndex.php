<?php

namespace App\Livewire\Warehouse\Categories;

use App\Models\Warehouse\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $store;
    public $search;
    public $nav;

    public function render()
    {
        return view('livewire.warehouse.categories.category-index', [
            'categories' => $this->getCategories()
        ]);
    }

    public function getCategories()
    {
        $search = "%$this->search%";

        $categories = Category::query()
            ->when($this->search, function($query) use($search) {
                $query->where('name', 'like', $search);
            })
            ->whereStoreId($this->store->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $categories;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        $this->render();
    }
}

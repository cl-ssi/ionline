<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use App\Models\Requirements\Category;

class Categories extends Component
{
    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $category;

    /** Listado de categorías */
    public $categories;

    /**
    * moun
    */
    public function mount()
    {
        $this->categories = auth()->user()->organizationalUnit->categories->sortBy('name');;
    }

    protected function rules()
    {
        return [
            'category.name' => 'required|min:4',
        ];
    }

    protected $messages = [
        'category.name.required' => 'El nombre es requerido.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
        $this->mount();
    }

    public function form(Category $category)
    {
        $this->category = Category::firstOrNew([ 'id' => $category->id ]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->category->organizational_unit_id = auth()->user()->organizational_unit_id;
        $this->category->save();
        $this->index();
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->index();
    }

    public function render()
    {
        return view('livewire.requirements.categories')->extends('layouts.bt4.app');
    }
}

<?php

namespace App\Livewire\Summary;

use Livewire\Component;
use App\Models\Summary\Type;

class TypeCrud extends Component
{
    public $types, $name, $type_id;
    public $isOpen = 0;

    public function render()
    {
        $this->types = Type::where('establishment_id',auth()->user()->establishment_id)->orderBy('name')->get();
        return view('livewire.summary.type-crud');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->dispatch('openModal');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->dispatch('closeModal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->type_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required'
        ]);

        Type::updateOrCreate(['id' => $this->type_id], [
            'name' => $this->name,
            'establishment_id' => auth()->user()->establishment_id
        ]);

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $this->type_id = $id;
        $this->name = $type->name;

        $this->openModal();
    }

    public function delete($id)
    {
        Type::find($id)->delete();
    }
}

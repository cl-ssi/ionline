<?php

namespace App\Http\Livewire\Warehouse\Family;

use Livewire\Component;

class FamilyEdit extends Component
{
    public $segment;
    public $family;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->family->name;
    }

    public function render()
    {
        return view('livewire.warehouse.family.family-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->family->update($dataValidated);
        $this->family->refresh();
    }
}

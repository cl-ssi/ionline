<?php

namespace App\Http\Livewire\Warehouse\Clase;

use Livewire\Component;

class ClaseEdit extends Component
{
    public $segment;
    public $family;
    public $class;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->class->name;
    }

    public function render()
    {
        return view('livewire.warehouse.class.class-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->class->update($dataValidated);
        $this->class->refresh();
    }
}

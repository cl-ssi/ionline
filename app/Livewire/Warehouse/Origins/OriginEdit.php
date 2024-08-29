<?php

namespace App\Livewire\Warehouse\Origins;

use Livewire\Component;

class OriginEdit extends Component
{
    public $store;
    public $origin;
    public $name;
    public $nav;

    public $rules = [
        'name'  => 'required|string|min:2|max:255',
    ];

    public function mount()
    {
        $this->name = $this->origin->name;
    }

    public function render()
    {
        return view('livewire.warehouse.origins.origin-edit');
    }

    public function updateOrigin()
    {
        $dataValidated = $this->validate();
        $this->origin->update($dataValidated);

        session()->flash('success', "El origen fue actualizado el exitosamente.");

        return redirect()->route('warehouse.origins.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

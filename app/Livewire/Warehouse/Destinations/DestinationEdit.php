<?php

namespace App\Livewire\Warehouse\Destinations;

use Livewire\Component;

class DestinationEdit extends Component
{
    public $store;
    public $destination;
    public $name;
    public $nav;

    public $rules = [
        'name'  => 'required|string|min:2|max:255',
    ];

    public function mount()
    {
        $this->name = $this->destination->name;
    }

    public function render()
    {
        return view('livewire.warehouse.destinations.destination-edit');
    }

    public function updateDestination()
    {
        $dataValidated = $this->validate();
        $this->destination->update($dataValidated);

        session()->flash('success', "El destino fue actualizado el exitosamente.");

        return redirect()->route('warehouse.destinations.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

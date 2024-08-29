<?php

namespace App\Livewire\Warehouse\Destinations;

use App\Models\Warehouse\Destination;
use Livewire\Component;

class DestinationCreate extends Component
{
    public $store;
    public $name;
    public $nav;

    public $rules = [
        'name'  => 'required|string|min:2|max:255',
    ];

    public function render()
    {
        return view('livewire.warehouse.destinations.destination-create');
    }

    public function createDestination()
    {
        $dataValidated = $this->validate();
        $dataValidated['store_id'] = $this->store->id;
        Destination::create($dataValidated);

        session()->flash('success', "El destino se ha creado exitosamente.");

        return redirect()->route('warehouse.destinations.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

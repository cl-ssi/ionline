<?php

namespace App\Livewire\Warehouse\Stores;

use App\Models\Commune;
use App\Models\Establishment;
use Livewire\Component;

class StoreEdit extends Component
{
    public $store;
    public $communes;
    public $name;
    public $address;
    public $commune_id;
    public $establishment_id;

    public $rules = [
        'name' => 'required|string|min:2|max:255',
        'address' => 'required|string|min:5|max:255',
        'commune_id' => 'required|exists:communes,id',
        'establishment_id' => 'required|exists:establishments,id'
    ];

    public function mount()
    {
        $this->communes = Commune::all();
        $this->establishments = Establishment::all();

        $this->name = $this->store->name;
        $this->address = $this->store->address;
        $this->commune_id = $this->store->commune_id;
        $this->establishment_id = $this->store->establishment_id;
    }

    public function render()
    {
        return view('livewire.warehouse.stores.store-edit');
    }

    public function updateStore()
    {
        $dataValidated = $this->validate();
        $this->store->update($dataValidated);

        return redirect()->route('warehouse.stores.index');
    }
}

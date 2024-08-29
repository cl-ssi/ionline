<?php

namespace App\Livewire\Warehouse\Origins;

use App\Models\Warehouse\Origin;
use Livewire\Component;

class OriginCreate extends Component
{
    public $store;
    public $name;
    public $nav;

    public $rules = [
        'name'  => 'required|string|min:2|max:255',
    ];

    public function render()
    {
        return view('livewire.warehouse.origins.origin-create');
    }

    public function createOrigin()
    {
        $dataValidated = $this->validate();
        $dataValidated['store_id'] = $this->store->id;
        Origin::create($dataValidated);

        session()->flash('success', "El origen se ha creado exitosamente.");

        return redirect()->route('warehouse.origins.index', [
            'store' => $this->store,
            'nav' => $this->nav,
        ]);
    }
}

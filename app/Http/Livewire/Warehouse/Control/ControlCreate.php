<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\Control;
use Livewire\Component;

class ControlCreate extends Component
{
    public $store;
    public $type;
    public $date;
    public $note;
    public $origin_id;
    public $destination_id;

    public $rulesReceiving = [
        'date'      => 'required|date_format:Y-m-d',
        'note'      => 'required|string|min:2|max:255',
        'origin_id' => 'required|exists:wre_origins,id',
    ];

    public $rulesDispatch = [
        'date'              => 'required|date_format:Y-m-d',
        'note'              => 'required|string|min:2|max:255',
        'destination_id'    => 'required|exists:wre_destinations,id',
    ];

    public function render()
    {
        return view('livewire.warehouse.control.control-create');
    }

    public function createControl()
    {
        $rules = ($this->type == 'receiving') ? $this->rulesReceiving : $this->rulesDispatch;
        $typeName = ($this->type == 'receiving') ? 'ingreso' : 'egreso';

        $dataValidated = $this->validate($rules);

        $dataValidated['store_id'] = $this->store->id;
        $dataValidated['type'] = ($this->type == 'receiving') ? 1 : 0;

        $control = Control::create($dataValidated);

        session()->flash('success', "Se ha guardado el encabezado del $typeName.");

        return redirect()->route('warehouse.control.add-product', [
            'store' => $this->store,
            'control' => $control
        ]);
    }

}

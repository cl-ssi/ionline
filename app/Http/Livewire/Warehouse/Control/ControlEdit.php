<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Warehouse\Store;
use Livewire\Component;

class ControlEdit extends Component
{
    public $store;
    public $control;
    public $type;
    public $date;
    public $note;
    public $type_dispatch_id;
    public $type_reception_id;
    public $origin_id;
    public $destination_id;
    public $store_origin_id;
    public $store_destination_id;
    public $stores;

    public $rulesReceiving = [
        'date'              => 'required|date_format:Y-m-d',
        'note'              => 'required|string|min:2|max:255',
        'origin_id'         => 'nullable|required_if:type_reception_id,1|integer|exists:wre_origins,id',
        'store_origin_id'   => 'nullable|required_if:type_reception_id,2|integer|exists:wre_type_receptions,id',
    ];

    public $rulesDispatch = [
        'date'                  => 'required|date_format:Y-m-d',
        'note'                  => 'required|string|min:2|max:255',
        'destination_id'        => 'nullable|required_if:type_dispatch_id,1|integer|exists:wre_destinations,id',
        'store_destination_id'  => 'nullable|required_if:type_dispatch_id,3|integer|exists:wre_type_receptions,id',
    ];

    public function mount()
    {
        $this->date = $this->control->date_format;
        $this->note = $this->control->note;
        $this->origin_id = $this->control->origin_id;
        $this->destination_id = $this->control->destination_id;
        $this->type_dispatch_id = $this->control->type_dispatch_id;
        $this->type_reception_id = $this->control->type_reception_id;
        $this->store_origin_id = $this->control->store_origin_id;
        $this->store_destination_id = $this->control->store_destination_id;
        $this->stores = Store::all();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-edit');
    }

    public function controlUpdate()
    {
        $rules = ($this->type == 'receiving') ? $this->rulesReceiving : $this->rulesDispatch;
        $dataValidated = $this->validate($rules);

        $this->control->update($dataValidated);

        session()->flash('success', "Se ha actualizado el  " . $this->control->type_format . " exitosamente.");

        return redirect()->route('warehouse.control.add-product', [
            'store' => $this->store,
            'control'  => $this->control
        ]);
    }
}

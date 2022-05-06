<?php

namespace App\Http\Livewire\Warehouse\Control;

use Livewire\Component;

class ControlEdit extends Component
{
    public $store;
    public $control;
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

    public function mount()
    {
        $this->date = $this->control->date_format;
        $this->note = $this->control->note;
        $this->origin_id = $this->control->origin_id;
        $this->destination_id = $this->control->destination_id;
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

<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Cfg\Program;
use App\Models\Warehouse\Control;
use Livewire\Component;

class ControlCreate extends Component
{
    public $store;
    public $type;
    public $type_dispatch;
    public $date;
    public $note;
    public $program_id;
    public $origin_id;
    public $destination_id;
    public $programs;

    public $rulesReceiving = [
        'date'          => 'required|date_format:Y-m-d',
        'note'          => 'required|string|min:2|max:255',
        'program_id'    => 'nullable|integer|exists:frm_programs,id',
        'origin_id'     => 'required|exists:wre_origins,id',
    ];

    public $rulesDispatch = [
        'date'              => 'required|date_format:Y-m-d',
        'note'              => 'required|string|min:2|max:255',
        'program_id'        => 'nullable|integer|exists:frm_programs,id',
        'destination_id'    => 'nullable|required_if:type_dispatch,0|integer|exists:wre_destinations,id',
        'type_dispatch'     => 'required|boolean',
    ];

    public function mount()
    {
        $this->type_dispatch = 0;
        $this->programs = Program::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-create');
    }

    public function createControl()
    {
        $rules = ($this->type == 'receiving') ? $this->rulesReceiving : $this->rulesDispatch;

        $dataValidated = $this->validate($rules);
        $dataValidated['store_id'] = $this->store->id;
        $dataValidated['type'] = ($this->type == 'receiving') ? 1 : 0;

        $dataValidated['adjust_inventory'] = ($this->type == 'dispatch') ? $dataValidated['type_dispatch'] : 0;

        $control = Control::create($dataValidated);

        session()->flash('success', "Se ha guardado el encabezado del $control->type_format.");

        return redirect()->route('warehouse.control.add-product', [
            'store' => $this->store,
            'control' => $control
        ]);
    }

}

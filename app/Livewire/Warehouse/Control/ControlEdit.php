<?php

namespace App\Livewire\Warehouse\Control;

use App\Models\Warehouse\Store;
use Livewire\Attributes\On;
use Livewire\Component;

class ControlEdit extends Component
{
    public $store;
    public $control;
    public $type;
    public $date;
    public $note;
    public $document_type;
    public $document_date;
    public $document_number;
    public $type_dispatch_id;
    public $type_reception_id;
    public $origin_id;
    public $destination_id;
    public $store_origin_id;
    public $store_destination_id;
    public $stores;
    public $nav;

    public $organizational_unit_id;
    public $establishment_id;

    public $rulesReceiving = [
        'date'              => 'required|date_format:Y-m-d',
        'note'              => 'nullable|string|min:2|max:255',
        'origin_id'         => 'nullable|required_if:type_reception_id,1|integer|exists:wre_origins,id',
        'store_origin_id'   => 'nullable|required_if:type_reception_id,2|integer|exists:wre_type_receptions,id',
        'document_type'     => 'nullable',
        'document_number'   => 'nullable|string|min:1|max:255',
        'document_date'     => 'nullable|date_format:Y-m-d',
    ];

    public $rulesDispatch = [
        'date'                  => 'required|date_format:Y-m-d',
        'note'                  => 'nullable|string|min:2|max:255',
        'destination_id'        => 'nullable|required_if:type_dispatch_id,4|exists:wre_destinations,id',
        'store_destination_id'  => 'nullable|required_if:type_dispatch_id,3|exists:wre_type_receptions,id',
        'organizational_unit_id' => 'nullable|required_if:type_dispatch_id,1|exists:organizational_units,id',
    ];

    public function mount()
    {
        $this->date = $this->control->date_format;
        $this->note = $this->control->note;
        $this->document_type = $this->control->document_type;
        $this->document_date = $this->control->document_date;
        $this->document_number = $this->control->document_number;

        $this->origin_id = $this->control->origin_id;
        $this->destination_id = $this->control->destination_id;
        $this->type_dispatch_id = $this->control->type_dispatch_id;
        $this->type_reception_id = $this->control->type_reception_id;
        $this->store_origin_id = $this->control->store_origin_id;
        $this->store_destination_id = $this->control->store_destination_id;
        $this->stores = Store::all();

        if($this->control->organizationalUnit)
        {
            $this->organizational_unit_id = $this->control->organizationalUnit->id;
            $this->establishment_id = $this->control->organizationalUnit->establishment_id;
        }
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
            'control'  => $this->control,
            'type' => $this->control->isReceiving() ? 'receiving' : 'dispatch',
            'nav' => $this->nav,
        ]);
    }

    public function updatedTypeDispatchId()
    {
        $this->reset([
            'date',
            'note',
            'destination_id',
            'store_destination_id',
            'program_id',
            'organizational_unit_id',
        ]);
    }

    #[On('organizationalId')]
    public function organizationalId($value)
    {
        $this->organizational_unit_id = $value;
    }
}

<?php

namespace App\Http\Livewire\His;

use Livewire\Component;
use App\Models\Parameters\Parameter;
use App\Models\His\ModificationRequest;

class NewModification extends Component
{
    public $modrequest;
    public $types;

    protected $rules = [
        'modrequest.type' => 'required',
        'modrequest.subject' => 'required|min:4',
        'modrequest.body' => 'nullable',
        'modrequest.status' => 'nullable',
    ];

    protected $messages = [
        'modrequest.type.required' => 'El tipo es obligatorio.',
        'modrequest.subject.required' => 'El asunto es obligatorio.',
    ];

    /**
    * mount
    */
    public function mount()
    {
        $this->types = explode(',',Parameter::get('his_modifications','tipos_de_solicitudes'));
    }

    /**
    * Guardar
    */
    public function save()
    {
        $this->validate();
        $modrequest = ModificationRequest::make($this->modrequest);
        $modrequest->creator_id = auth()->id();

        $modrequest->save();
        session()->flash('success', 'Se ha creado la nueva solicitud.');
    }

    public function render()
    {
        return view('livewire.his.new-modification');
    }
}

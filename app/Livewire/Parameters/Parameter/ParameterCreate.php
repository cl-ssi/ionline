<?php

namespace App\Livewire\Parameters\Parameter;

use App\Http\Requests\Parameters\Parameter\CreateParameterRequest;
use App\Models\Parameters\Parameter;
use Livewire\Component;
use App\Models\Establishment;

class ParameterCreate extends Component
{
    public $module;
    public $parameter_field;
    public $value;
    public $description;
    public $establishment_id;
    public $establishments;

    public function mount()
    {
        $this->establishments = Establishment::all();
    }

    public function render()
    {
        return view('livewire.parameters.parameter.parameter-create')->extends('layouts.bt4.app');
    }

    public function rules()
    {
        return (new CreateParameterRequest($this->module, $this->establishment_id))->rules();
    }

    public function create()
    {
        $dataValidated = $this->validate();
        $dataValidated['parameter'] = $dataValidated['parameter_field'];
        Parameter::create($dataValidated);

        session()->flash('success', 'El parámetro fue creado exitosamente.');
        return redirect()->route('parameters.index');
    }
}

<?php

namespace App\Http\Livewire\Parameters\Parameter;

use App\Http\Requests\Parameters\Parameter\CreateParameterRequest;
use App\Models\Parameters\Parameter;
use Livewire\Component;

class ParameterCreate extends Component
{
    public $module;
    public $parameter_field;
    public $value;
    public $description;

    public function render()
    {
        return view('livewire.parameters.parameter.parameter-create')->extends('layouts.bt4.app');
    }

    public function rules()
    {
        return (new CreateParameterRequest($this->module))->rules();
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

<?php

namespace App\Http\Livewire\Parameters\Parameter;

use App\Http\Requests\Parameters\Parameter\UpdateParameterRequest;
use App\Models\Parameters\Parameter;
use Livewire\Component;

class ParameterEdit extends Component
{
    public $parameterEdit;

    public $module;
    public $parameter_field;
    public $value;
    public $description;

    public function render()
    {
        return view('livewire.parameters.parameter.parameter-edit')->extends('layouts.bt4.app');
    }

    public function mount($parameter)
    {
        $this->parameterEdit = Parameter::find($parameter);
        $this->module = $this->parameterEdit->module;
        $this->parameter_field = $this->parameterEdit->parameter;
        $this->value = $this->parameterEdit->value;
        $this->description = $this->parameterEdit->description;
    }

    public function rules()
    {
        return (new UpdateParameterRequest($this->parameterEdit, $this->module))->rules();
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $dataValidated['parameter'] = $dataValidated['parameter_field'];

        $this->parameterEdit->update($dataValidated);

        session()->flash('success', 'El parámetro fue actualizado exitosamente.');
        return redirect()->route('parameters.index');
    }
}

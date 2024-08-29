<?php

namespace App\Livewire\Parameters\Parameter;

use App\Http\Requests\Parameters\Parameter\UpdateParameterRequest;
use App\Models\Parameters\Parameter;
use Livewire\Component;
use App\Models\Establishment;

class ParameterEdit extends Component
{
    public $parameterEdit;

    public $module;
    public $parameter_field;
    public $value;
    public $description;
    public $establishment_id;
    public $establishments;

    public function render()
    {
        return view('livewire.parameters.parameter.parameter-edit')->extends('layouts.bt4.app');
    }

    public function mount($parameter)
    {
        $this->establishments = Establishment::all();
        $this->parameterEdit = Parameter::find($parameter);
        $this->module = $this->parameterEdit->module;
        $this->parameter_field = $this->parameterEdit->parameter;
        $this->value = $this->parameterEdit->value;
        $this->description = $this->parameterEdit->description;
        $this->establishment_id = $this->parameterEdit->establishment_id;
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

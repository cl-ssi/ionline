<?php

namespace App\Http\Livewire\Parameters\Program;

use Livewire\Component;

class ProgramEdit extends Component
{
    public $program;
    public $name;
    public $alias;
    public $start_date;
    public $end_date;

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'alias'         => 'required|string|min:2|max:50',
            'start_date'    => 'nullable|date_format:Y-m-d',
            'end_date'      => 'nullable|date_format:Y-m-d',
            'description'   => 'nullable|string|min:2|max:255',
        ];
    }

    public function render()
    {
        return view('livewire.parameters.program.program-edit');
    }

    public function mount()
    {
        $this->name = $this->program->name;
        $this->alias = $this->program->alias;
        $this->start_date = $this->program->start_date ? $this->program->start_date->format('Y-m-d') : null;
        $this->end_date = $this->program->end_date ? $this->program->end_date->format('Y-m-d') : null;
        $this->description = $this->program->description;
    }

    public function updateProgram()
    {
        $dataValidated = $this->validate();
        $this->program->update($dataValidated);

        session()->flash('success', 'El programa fue actualizado exitosamente.');
        return redirect()->route('parameters.programs.index');
    }
}

<?php

namespace App\Http\Livewire\Cfg\Program;

use App\Models\Cfg\Program;
use Livewire\Component;

class ProgramCreate extends Component
{
    public $name;
    public $start_date;
    public $end_date;
    public $description;

    public function render()
    {
        return view('livewire.cfg.program.program-create');
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'start_date'    => 'nullable|date_format:Y-m-d',
            'end_date'      => 'nullable|date_format:Y-m-d',
            'description'   => 'nullable|string|min:2|max:255',
        ];
    }

    public function createProgram()
    {
        $dataValidated = $this->validate();
        Program::create($dataValidated);

        session()->flash('success', 'El programa fue creado exitosamente.');
        return redirect()->route('cfg.programs.index');
    }
}

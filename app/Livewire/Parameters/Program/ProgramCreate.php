<?php

namespace App\Livewire\Parameters\Program;

use App\Models\Parameters\Parameter;
use App\Models\Parameters\Program;
use App\Models\Parameters\Subtitle;
use Livewire\Component;

class ProgramCreate extends Component
{
    public $name;
    public $alias;
    public $alias_finance;
    public $financial_type;
    public $folio;
    public $subtitle_id;
    public $budget;
    public $period;
    public $start_date;
    public $end_date;
    public $description;
    public $is_program;

    public $subtitles;

    public function render()
    {
        return view('livewire.parameters.program.program-create');
    }

    public function mount()
    {
        $this->subtitles = Subtitle::pluck('name','id');
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'alias'         => 'required|string|min:2|max:50',
            'alias_finance' => 'nullable|string|min:2|max:150',
            'financial_type'=> 'nullable|string|min:2|max:50',
            'folio'         => 'nullable|integer|min:1|max:99999',
            'subtitle_id'   => 'required|exists:cfg_subtitles,id',
            'budget'        => 'nullable|integer|min:1|max:99999999999',
            'period'        => 'required|integer|min:2015|max:2099',
            'start_date'    => 'nullable|date_format:Y-m-d',
            'end_date'      => 'nullable|date_format:Y-m-d',
            'description'   => 'nullable|string|min:2|max:255',
            'is_program'    => 'nullable',
        ];
    }

    public function createProgram()
    {
        $dataValidated = $this->validate();
        $estab_hetg = Parameter::get('establishment', 'HETG');
        $dataValidated['establishment_id'] = auth()->user()->establishment_id == $estab_hetg ? $estab_hetg : NULL;
        Program::create($dataValidated);

        session()->flash('success', 'El programa fue creado exitosamente.');
        return redirect()->route('parameters.programs.index');
    }
}

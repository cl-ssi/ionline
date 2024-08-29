<?php

namespace App\Livewire\Parameters\Program;

use App\Models\Parameters\Parameter;
use App\Models\Parameters\Program;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        return view('livewire.parameters.program.program-index', [
            'programs' => $this->getPrograms()
        ]);
    }

    public function getPrograms()
    {
        $search = "%$this->search%";
        $estab_hetg = Parameter::get('establishment', 'HETG');

        $programs = Program::query()
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->orWhere('alias', 'like', $search)
                    ->orWhere('description', 'like', $search);
            })
            // ->when(auth()->user()->establishment_id == Parameter::get('establishment', 'HETG'), function($query){
            //     $query->where('establishment_id', auth()->user()->establishment_id);
            // })
            ->where('establishment_id', auth()->user()->establishment_id == $estab_hetg ? $estab_hetg : NULL)
            ->orderBy('name')
            ->paginate(100);

        return $programs;
    }

    public function delete(Program $program)
    {
        $program->delete();
        $this->render();
    }
}

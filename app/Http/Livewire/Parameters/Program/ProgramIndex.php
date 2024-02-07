<?php

namespace App\Http\Livewire\Parameters\Program;

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

        $programs = Program::query()
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->orWhere('alias', 'like', $search)
                    ->orWhere('description', 'like', $search);
            })
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

<?php

namespace App\Http\Livewire\Cfg\Program;

use App\Models\Cfg\Program;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        return view('livewire.cfg.program.program-index', [
            'programs' => $this->getPrograms()
        ]);
    }

    public function getPrograms()
    {
        $search = "%$this->search%";

        $programs = Program::query()
            ->where('name', 'like', $search)
            ->paginate(10);

        return $programs;
    }
}

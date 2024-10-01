<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Parameters\Program;
use Livewire\Attributes\On;

class SearchSelectProgram extends Component
{
    /* Uso:
        *
        * @livewire('search-select-program')
        *
        * Se puede definir el nombre del campo que almacenará el id del programa
        * @livewire('search-select-program', ['selected_id' => 'program_id'])
        * 
        * Se puede definir el nombre del listener del metodo
        * @livewire('search-select-program', ['emit_name' => 'searchedProgram'])
        *
        * Si necesitas que aparezca precargado el programa
        * @livewire('search-select-program', ['program' => $program])
        *
    */

    public $query;
    public $programs;

    /* PARA PRECARGAR */
    public $program;
    public $selectedProgramName;
    public $selected_id = 'program_id';
    public $required = '';
    public $small_option = false;
    public $msg_too_many;
    public $disabled;

    public $emit_name;

    public $year;

    public function setProgram(Program $program)
    {
        $this->query = '';
        $this->programs = [];
        $this->program = null;
        $this->selectedProgramName = null;
        
        $this->program = $program;
        $this->selectedProgramName = $program->name.' subtítulo '.$program->Subtitle->name;
    }

    public function resetx()
    {
        $this->query = '';
        $this->programs = [];
        $this->program = null;
        $this->selectedProgramName = null;
        /*
        if($this->emit_name == 'searchedRequesterOu'){
            $this->dispatch('clearRequesterOu');
        }
        if($this->emit_name == 'searchedAdminOu'){
            $this->dispatch('clearAdminOu');
        }
        */
    }

    public function addSearchedProgram($programId){
        $this->searchedProgram = $programId;
        $this->dispatch($this->emit_name ?? 'searchedProgram', searchedProgram: $this->searchedProgram);
    }

    public function mount()
    {           
        if($this->program) {
            $this->setProgram($this->program);
        }
    }

    public function updatedQuery()
    {
        $this->programs = Program::getProgramsBySearch($this->query)
            ->where('period', $this->year)
            ->orderBy('name','Asc')
            ->orderBy('period', 'Desc')
            ->get();

        /** Más de 50 resultados  */
        if(count($this->programs) >= 25)
        {
            $this->programs = [];
            $this->msg_too_many = true;
        }
        else {
            $this->msg_too_many = false;
        }
    }

    #[On('contentChanged')]
    public function contentChanged($contentChanged)
    {
        $this->year = $contentChanged;
    }

    public function render()
    {
        return view('livewire.search-select-program');
    }
}

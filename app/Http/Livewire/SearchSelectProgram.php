<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Parameters\Program;

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

    public $emit_name;

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
            $this->emit('clearRequesterOu');
        }
        if($this->emit_name == 'searchedAdminOu'){
            $this->emit('clearAdminOu');
        }
        */
    }

    public function addSearchedProgram($programId){
        $this->searchedProgram = $programId;
        $this->emit($this->emit_name ?? 'searchedProgram', $this->searchedProgram);
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

    public function render()
    {
        return view('livewire.search-select-program');
    }
}

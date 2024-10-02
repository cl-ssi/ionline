<?php

namespace App\Livewire\RequestForm;

use App\Models\Parameters\Program;
use App\Models\RequestForms\RequestForm;
use Livewire\Component;
use Livewire\Attributes\On;

class SearchProgramAmounts extends Component
{
    public $selectedYear;
    public $selectedProgram;
    // public $programs = [];
    public $requestForms;

    // protected $queryString = ['selectedYear', 'selectedProgram'];

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

    protected function rules(){
        return [
          'selectedYear'    =>  'required',
          'selectedProgram' =>  'required'
        ];
    }

    public function updatedSelectedYear($value)
    {
        // $this->programs = Program::with('Subtitle')->orderBy('alias_finance')->where('period', $value)->get();
        $this->dispatch('contentChanged', contentChanged: $value);
    }

    public function updatedSelectedProgram()
    {
        /*
        $this->requestForms = RequestForm::with('father:id,folio,has_increased_expense', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'immediatePurchases.dtes')->where('program_id', $this->selectedProgram)->where('status', 'approved')->get();
        $this->dispatch('contentChanged');
        */
    }

    //Buscador de programas
    public function setProgram(Program $program)
    {
        $this->query = '';
        $this->programs = [];
        $this->program = null;
        $this->selectedProgramName = null;
        
        $this->program = $program;
        $this->selectedProgramName = $program->name;
    }

    public function resetx()
    {
        $this->query = '';
        $this->programs = [];
        $this->program = null;
        $this->selectedProgramName = null;
        if($this->emit_name == 'searchedProgram'){
            $this->dispatch('clearProgram');
        }
    }

    public function addSearchedProgram($programId){
        $this->searchedProgram = $programId;
        $this->dispatch($this->emit_name ?? 'searchedProgram', program: $this->searchedProgram);
    }

    public function mount()
    {   
        if($this->program) {
            $this->setProgram($this->program);
        }
    }

    public function updatedQuery()
    {
        $this->programs = OrganizationalUnit::getProgramsBySearch($this->query)
            ->orderBy('name','Asc')
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

    #[On('searchedProgram')]
    public function searchedProgram($searchedProgram)
    {
        $this->selectedProgram = $searchedProgram;
    }

    public function search()
    {
        $this->validate([
            'selectedYear'      => 'required|integer',
            'selectedProgram'   => 'required'
        ], [
            'selectedYear.required'     => 'Por favor, selecciona un año.',
            'selectedProgram.required'  => 'Por favor, selecciona un programa.'
        ]);

        $this->requestForms = RequestForm::with('father:id,folio,has_increased_expense', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'immediatePurchases.dtes')->where('program_id', $this->selectedProgram)->where('status', 'approved')->get();
    }

    public function render()
    {
        return view('livewire.request-form.search-program-amounts');
    }
}

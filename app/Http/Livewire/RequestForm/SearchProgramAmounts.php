<?php

namespace App\Http\Livewire\RequestForm;

use App\Models\Parameters\Program;
use App\Models\RequestForms\RequestForm;
use Livewire\Component;

class SearchProgramAmounts extends Component
{
    public $selectedYear;
    public $selectedProgram;
    public $programs = [];
    public $requestForms;

    // protected $queryString = ['selectedYear', 'selectedProgram'];

    protected function rules(){
        return [
          'selectedYear'    =>  'required',
          'selectedProgram' =>  'required'
        ];
    }

    public function updatedSelectedYear($value)
    {
        $this->programs = Program::with('Subtitle')->orderBy('alias_finance')->where('period', $value)->get();
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function updatedSelectedProgram()
    {
        $this->requestForms = RequestForm::with('father:id,folio,has_increased_expense', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'immediatePurchases.dtes')->where('program_id', $this->selectedProgram)->where('status', 'approved')->get();
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function render()
    {
        return view('livewire.request-form.search-program-amounts');
    }
}

<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\Parameters\ProgramBudget;
use App\Models\Parameters\Program;
use App\Models\RequestForms\RequestForm;




class ReportGlobalBudget extends Component
{

    public $selectedYear;
    public $programs = [];
    public $requestForms;


    public function updatedSelectedYear()
    {


        //Trae todos los de un año
        $this->programs = Program::where('period', $this->selectedYear)->orderBy('name')->get();

        //trae la suma como un vector de los programas
        // $budgets = ProgramBudget::get()->groupBy('program_id')->map(function ($row) {
        //     return $row->sum('ammount');
        // })->toArray();

        /*Filtra los programas para que me muestre no todos sino solamente los que tienen presupuesto*/

        // $this->programs = $this->programs->filter(function ($program) use ($budgets) {
        //     return array_key_exists($program->id, $budgets);
        // });

        foreach ($this->programs as $program) {
            $program->totalCompras = 0;
            $program->totalDtes = 0;
            $program->totalBudgets = 0;

            $program->total_expense = RequestForm::where('program_id', $program->id)->where('status', 'approved')->sum('estimated_expense');

            $program->totalBudgets = ProgramBudget::where('program_id', $program->id)->sum('ammount');

            $requestForms = RequestForm::with('father:id,folio,has_increased_expense', 'purchasingProcess.details', 'purchasingProcess.detailsPassenger', 'immediatePurchases.dtes')->where('program_id', $program->id)->where('status', 'approved')->get();

            foreach ($requestForms as $requestForm) {
                if ($requestForm->purchasingProcess && ($requestForm->purchasingProcess->details->count() > 0 || $requestForm->purchasingProcess->detailsPassenger->count() > 0))
                {
                    $program->totalCompras += $requestForm->purchasingProcess->getExpense();
                }
                if($requestForm->immediatePurchases->count() > 0)
                {
                    $program->totalDtes += $requestForm->getTotalDtes();
                }
            }
        }
        $this->render();
    }

    public function render()
    {
        return view('livewire.request-form.report-global-budget')->extends('layouts.bt4.app');
    }
}

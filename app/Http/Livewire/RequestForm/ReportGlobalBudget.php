<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\Parameters\ProgramBudget;
use App\Models\Parameters\Program;




class ReportGlobalBudget extends Component
{

    public $selectedYear;
    public $programs = [];


    public function updatedSelectedYear($value)
    {
        $this->programs = Program::where('period', $value)->get();

        $budgets = ProgramBudget::get()->groupBy('program_id')->map(function ($row) {
            return $row->sum('ammount');
        })->toArray();

        $this->programs = $this->programs->filter(function ($program) use ($budgets) {
            return array_key_exists($program->id, $budgets);
        });
    }

    public function render()
    {
        return view('livewire.request-form.report-global-budget');
    }
}

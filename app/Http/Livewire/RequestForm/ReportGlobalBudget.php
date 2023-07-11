<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\Parameters\Program;


class ReportGlobalBudget extends Component
{

    public $selectedYear;
    public $programs = [];


    public function updatedSelectedYear($value)
    {
        $this->programs = Program::where('period', $value)->get();
    }

    public function render()
    {
        return view('livewire.request-form.report-global-budget');
    }
}

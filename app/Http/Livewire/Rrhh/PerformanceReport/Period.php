<?php

namespace App\Http\Livewire\Rrhh\PerformanceReport;

use App\Models\Rrhh\PerformanceReportPeriod;
use Livewire\Component;

class Period extends Component
{
    public $number; // por ahora no lo utilizaré quizás si piden mostrar otro ordenamiento
    public $name;
    public $start_at;
    public $end_at;
    public $year;
    public $showForm = false; 
    public $showSuccessMessage = false;

    public function render()
    {
        $periods = PerformanceReportPeriod::all();
        return view('livewire.rrhh.performance-report.period', ['periods' => $periods]);
    }

    public function mount()
    {        
        $this->year = now()->year;
    }


    public function createPeriod()
    {
        $this->validate([
            'name' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'year' => 'required|integer',
        ]);

        PerformanceReportPeriod::create([
            'name' => $this->name,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'year' => $this->year,
        ]);

        $this->showSuccessMessage = true;
        $this->resetFields();
        $this->showForm = false;
    }

    public function deletePeriod($id)
    {
        PerformanceReportPeriod::find($id)->delete();
    }

    private function resetFields()
    {
        $this->name = '';
        $this->start_at = '';
        $this->end_at = '';
        $this->year = '';
    }
}

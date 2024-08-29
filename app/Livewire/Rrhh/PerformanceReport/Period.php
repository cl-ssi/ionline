<?php

namespace App\Livewire\Rrhh\PerformanceReport;

use App\Models\Rrhh\PerformanceReportPeriod;
use Livewire\Component;
use Carbon\Carbon;

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
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'year' => 'required|integer',
        ]);
        
        
        // $startOfMonth = Carbon::parse($this->start_at)->startOfMonth()->locale('es');
        // $endOfMonth = Carbon::parse($this->end_at)->endOfMonth()->locale('es');

        // //$name = $startOfMonth->formatLocalized('%b') . '-' . $endOfMonth->formatLocalized('%b');
        // $name = $startOfMonth->formatLocalized('%b', setlocale(LC_ALL, 'es_CL.UTF-8')) . '-' . $endOfMonth->formatLocalized('%b', setlocale(LC_ALL, 'es_CL.UTF-8'));


        // setlocale(LC_ALL, 'es_CL.UTF-8');

        // $startOfMonth = Carbon::parse($this->start_at)->startOfMonth();
        // $endOfMonth = Carbon::parse($this->end_at)->endOfMonth();

        // $name = ucfirst($startOfMonth->formatLocalized('%b')) . '-' . ucfirst($endOfMonth->formatLocalized('%b'));

        $startOfMonth = Carbon::parse($this->start_at)->startOfMonth();
        $endOfMonth = Carbon::parse($this->end_at)->endOfMonth();

        $startMonthName = $startOfMonth->monthName;
        $endMonthName = $endOfMonth->monthName;

        $name = ucfirst($startMonthName) . '-' . ucfirst($endMonthName);




        PerformanceReportPeriod::create([
            'name' => $name,
            'start_at' => $startOfMonth,
            'end_at' => $endOfMonth,
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
        $this->start_at = '';
        $this->end_at = '';        
    }
}

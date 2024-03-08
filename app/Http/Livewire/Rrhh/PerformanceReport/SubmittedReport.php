<?php

namespace App\Http\Livewire\Rrhh\PerformanceReport;

use Livewire\Component;
use App\User;
use App\Models\Rrhh\PerformanceReportPeriod;

class SubmittedReport extends Component
{


    public $users;
    public $organizationalUnit;
    public $year;
    public $periods;

    public function mount()
    {
        $loggedInUser = auth()->user();
        $this->organizationalUnit = $loggedInUser->organizationalUnit->name;
        $this->users = User::where('organizational_unit_id', $loggedInUser->organizational_unit_id)
                   ->orderBy('name')
                   ->get();

                // Obtener el año seleccionado
        // Obtener el año seleccionado
        $year = $this->year ?? now()->year;
        $this->periods = PerformanceReportPeriod::where('year', $year)->get();
        $this->periods = $this->periods->sortBy('start_at');

    }


    public function render()
    {
        return view('livewire.rrhh.performance-report.submitted-report');
    }
}

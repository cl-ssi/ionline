<?php

namespace App\Http\Livewire\Rrhh\PerformanceReport;

use Livewire\Component;
use App\User;

class SubmittedReport extends Component
{


    public $users;
    public $organizationalUnit;

    public function mount()
    {
        $loggedInUser = auth()->user();
        $this->organizationalUnit = $loggedInUser->organizationalUnit->name;
        $this->users = User::where('organizational_unit_id', $loggedInUser->organizational_unit_id)
                   ->orderBy('name')
                   ->get();
    }


    public function render()
    {
        return view('livewire.rrhh.performance-report.submitted-report');
    }
}

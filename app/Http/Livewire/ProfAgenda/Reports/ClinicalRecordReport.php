<?php

namespace App\Http\Livewire\ProfAgenda\Reports;

use Livewire\Component;

use App\User;
use App\Models\ProfAgenda\OpenHour;

class ClinicalRecordReport extends Component
{
    public $patient;
    public $passedOpenHours = [];
    public $nextOpenHours = [];

    protected $listeners = ['get_user' => 'get_user'];
 
    public function get_user(User $user)
    {
        $this->patient = $user;
    }

    public function search()
    {
        $this->passedOpenHours = OpenHour::where('patient_id',$this->patient->id)
                                    ->where('start_date','<=',now())
                                    ->orderBy('start_date')
                                    ->get();

        $this->nextOpenHours = OpenHour::where('patient_id',$this->patient->id)
                                    ->where('start_date','>',now())
                                    ->orderBy('start_date')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.prof-agenda.reports.clinical-record-report');
    }
}

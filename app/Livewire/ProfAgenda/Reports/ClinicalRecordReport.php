<?php

namespace App\Livewire\ProfAgenda\Reports;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\ProfAgenda\OpenHour;

class ClinicalRecordReport extends Component
{
    public $patient;
    public $passedOpenHours = [];
    public $nextOpenHours = [];

    public $showSelect = false;
    public $selectedAssistance;
    public $openHours = [];

    // Otros métodos del componente...

    public function mount()
    {
        // Inicializa el array openHours con el estado inicial para cada fila
        foreach ($this->passedOpenHours as $openHour) {
            $this->openHours[$openHour->id] = [
                'showSelect' => false,
                'selectedAssistance' => null,
            ];
        }
    }

    public function showSelect($openHourId)
    {
        $this->openHours[$openHourId]['showSelect'] = true;
    }

    public function hideSelect($openHourId)
    {
        $this->openHours[$openHourId]['showSelect'] = false;
    }

    public function updateAssistance($openHourId, $selectedAssistance)
    {
        if($selectedAssistance!=2){
            $openHour = OpenHour::find($openHourId);
            $openHour->assistance = $selectedAssistance;
            $openHour->save();
        }
        
        $this->hideSelect($openHourId);
    }

    #[On('get_user')]
    public function get_user($userId)
    {
        $this->patient = User::find($userId);
    }

    public function search()
    {
        $this->passedOpenHours = OpenHour::where('patient_id',$this->patient->id)
                                    ->where('start_date','<=',now())
                                    ->orderBy('start_date','DESC')
                                    ->take(10)
                                    ->get();

        $this->nextOpenHours = OpenHour::where('patient_id',$this->patient->id)
                                    ->where('start_date','>',now())
                                    ->orderBy('start_date','DESC')
                                    ->take(10)
                                    ->get();
    }

    public function render()
    {
        if($this->patient){
            $this->search();
        }

        return view('livewire.prof-agenda.reports.clinical-record-report');
    }
}

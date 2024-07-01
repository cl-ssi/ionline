<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\ProfAgenda\ActivityType;
use App\Models\ProfAgenda\OpenHour;

class SelectActivityTypeOpenHours extends Component
{
    public $profession_id;
    public $profesional_id;
    public $activityTypes = [];

    public function mount(){
        $activityTypes = OpenHour::where('profesional_id',$this->profesional_id)
                            ->where('profession_id',$this->profession_id)
                            ->whereHas('activityType')
                            ->with('activityType')
                            ->whereNull('patient_id')
                            ->pluck('activity_type_id')->toArray();
                            
        $this->activityTypes = ActivityType::whereIn('id',array_unique($activityTypes))->get();

    }

    public function render()
    {
        return view('livewire.prof-agenda.select-activity-type-open-hours');
    }
}

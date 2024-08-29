<?php

namespace App\Livewire\ProfAgenda;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\ProfAgenda\ActivityType;
use App\Models\ProfAgenda\OpenHour;

class AddAgendaBlock extends Component
{
    public $profession_id;
    public $profesional_id;

    public $date;
    public $start_hour;
    public $end_hour;
    public $duration;
    public $activity_type_id;

    protected $rules = [
        'date' => 'required',
        'start_hour' => 'required',
        'end_hour' => '',
        'duration' => '',
        'activity_type_id' => '',
    ];

    protected $messages = [
        'date' => 'El campo es requerido.',
        'start_hour' => 'El campo es requerido.',
        'end_hour' => 'El campo es requerido.',
        'duration' => 'El campo es requerido.',
        'activity_type_id' => 'El campo es requerido.',
    ];

    public function mount(){
        $this->activity_types = ActivityType::all();
    }

    public function save(){
        $this->validate();
        $date = Carbon::parse($this->date);
        $start_date = Carbon::parse($date->format('Y-m-d') . " " . $this->start_hour);
        $end_date = Carbon::parse($date->format('Y-m-d') . " " . $this->end_hour);
        // dd($start_date, $end_date);

        if($start_date <= $end_date){
            foreach (CarbonPeriod::create($start_date, $this->duration . " minutes", $end_date)->excludeEndDate() as $key => $hour) {
                $newOpenHour = new OpenHour();
                $newOpenHour->start_date = $date->format('Y-m-d') . " " . $hour->format('H:i');
                $newOpenHour->end_date = Carbon::parse($date->format('Y-m-d') . " " . $hour->format('H:i'))->addMinutes($this->duration)->format('Y-m-d H:i');
                $newOpenHour->profesional_id = $this->profesional_id;
                $newOpenHour->profession_id = $this->profession_id; 
                $newOpenHour->activity_type_id = $this->activity_type_id;
                $newOpenHour->save();
            }
        }
        // dd("");
        session()->flash('success', 'Se agregó el bloque.');
        return redirect()->to('prof_agenda/proposals/edit/'.$this->proposal->id);
    }

    public function render()
    {
        return view('livewire.prof-agenda.add-agenda-block');
    }
}

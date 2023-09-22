<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\ProfAgenda\OpenHour;
use App\User;

class Agenda extends Component
{
    public $profession_id;
    public $profesional_id;
    public $user_id;

    public $events = '';
    // public $proposals;

    public function render()
    {
        $array = array();
        $count = 0;

        $openHours = OpenHour::where('profesional_id',$this->profesional_id)->where('profession_id',$this->profession_id)->get();
        // dd($openHours);
        foreach($openHours as $hour){
            $array[$count]['id'] = $hour->id;
            $array[$count]['observation'] = $hour->observation;
            $array[$count]['contact_number'] = $hour->contact_number;
            $array[$count]['start'] = $hour->start_date;
            $array[$count]['end'] = $hour->end_date;
            // reservado
            if($hour->patient_id){
                $array[$count]['color'] = "#EB9489";
                $array[$count]['title'] = $hour->patient->shortName;
                $array[$count]['status'] = "Reservado";
            }
            // sin reserva
            else{
                $array[$count]['color'] = "#CACACA";
                $array[$count]['title'] = $hour->activityType->name;
                $array[$count]['status'] = "Disponible";
            }
            // bloqueado
            if($hour->blocked){
                $array[$count]['color'] = "#85C1E9";
                $array[$count]['title'] = "Bloqueado";
                $array[$count]['status'] = "Bloqueado";
                $array[$count]['deleted_bloqued_observation'] = $hour->deleted_bloqued_observation;
            }
            $count += 1;
        }


        $this->events = json_encode($array);

        return view('livewire.prof-agenda.agenda');
    }
}

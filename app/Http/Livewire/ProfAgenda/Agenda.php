<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

class Agenda extends Component
{
    public $events = '';
    public $proposals;

    public function render()
    {
        $array = array();
        $count = 0;
        
        // última ficha aceptada
        foreach($this->proposals as $key => $proposal){
            foreach($proposal->details as $key2 => $detail){
                foreach($detail->openHours as $key3 => $hour){
                    {
                        $array[$count]['id'] = $hour->id;
                        $array[$count]['observation'] = $hour->observation;
                        $array[$count]['contact_number'] = $hour->contact_number;
                        $array[$count]['start'] = $hour->start_date;
                        $array[$count]['end'] = $hour->end_date;
                        if($hour->patient_id){
                            $array[$count]['color'] = "#EB9489";
                            $array[$count]['title'] = $hour->patient->shortName;
                            $array[$count]['status'] = "Reservado";
                        }
                        else{
                            $array[$count]['color'] = "#CACACA";
                            $array[$count]['title'] = $hour->detail->activityType->name;
                            $array[$count]['status'] = "Disponible";
                        }
                        if($hour->blocked){
                            $array[$count]['color'] = "#85C1E9";
                            $array[$count]['title'] = "Bloqueado";
                            $array[$count]['status'] = "Bloqueado";
                        }
                        $count += 1;
                    }
                }
            }
        }

        $this->events = json_encode($array);

        return view('livewire.prof-agenda.agenda');
    }
}

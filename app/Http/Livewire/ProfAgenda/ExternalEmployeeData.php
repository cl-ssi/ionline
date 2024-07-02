<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;
use App\Models\ClCommune;
use App\Models\ProfAgenda\ExternalUser;
use App\Models\ProfAgenda\OpenHour;

class ExternalEmployeeData extends Component
{
    public $user_id = 0;
    public $dv;
    public $email;
    public $message;
    public $flag_more_than_3_faults = false;

    protected $listeners = ['loadUserData' => 'loadUserData'];

    public function loadUserData(ExternalUser $User){
        $this->user_id = $User->id;
        $this->dv = $User->dv;
        $this->render();
    }

    public function render()
    {
        $communes = ClCommune::orderBy('name', 'ASC')->get();
        $user = new ExternalUser();

        $this->message = "";
        if ($this->user_id > 3000000) {
            $user = ExternalUser::find($this->user_id);
            $this->emit('renderFromEmployeeData');

            // validación datos de usuario
            if ($user) {

                // validación para verificar funcionarios con 3 faltas consecutivas en los ultimos 2 meses
                $twoMonthsAgo = now()->subMonths(2);
                $openHours = OpenHour::where('external_user_id',$user->id)
                                    ->orderBy('start_date')
                                    ->where('start_date', '>=', $twoMonthsAgo)
                                    ->get();
                $count = 0;
                foreach($openHours as $openHour){
                    if($openHour->assistance === 0){
                        $count += 1;
                    }
                    if($openHour->assistance !== 0){
                        $count = 0;
                    }
                    if($count >= 3){
                        $this->flag_more_than_3_faults = true;
                    }
                }

                $this->email = $user->email;
            }else{
                // validación correo
                if ($this->email != null) {
                $user = ExternalUser::where('email',$this->email)->first();
                if ($user != null) {
                    $this->message = "No es posible utilizar el coreo " . $this->email . ", ya está siendo utilizado por " . $user->getFullNameUpperAttribute();
                }
                }
            }
        }

        return view('livewire.prof-agenda.external-employee-data',compact('user','communes'));
    }
}

<?php

namespace App\Livewire\ProfAgenda;

use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\ClCommune;
use App\Models\ProfAgenda\ExternalUser;
use App\Models\ProfAgenda\OpenHour;

class ExternalEmployeeData extends Component
{
    public $externaluser_id = 0;
    public $dv;
    public $email;
    public $message;
    public $flag_more_than_3_faults = false;

    #[On('loadexternatlUserData')] 
    public function loadexternalUserData(ExternalUser $externalUser){
        $this->externaluser_id = $externalUser->id;
        $this->dv = $externalUser->dv;
        $this->render();
    }

    public function render()
    {
        $communes = ClCommune::orderBy('name', 'ASC')->get();
        $externaluser = new ExternalUser();

        $this->message = "";
        if ($this->externaluser_id > 3000000) {
            $externaluser = ExternalUser::find($this->externaluser_id);
            $this->dispatch('renderFromEmployeeData');

            // validación datos de usuario
            if ($externaluser) {

                // validación para verificar funcionarios con 3 faltas consecutivas en los ultimos 2 meses
                $twoMonthsAgo = now()->subMonths(2);
                $openHours = OpenHour::where('external_user_id',$externaluser->id)
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

                $this->email = $externaluser->email;
            }else{
                // validación correo
                if ($this->email != null) {
                $externaluser = ExternalUser::where('email',$this->email)->first();
                if ($externaluser != null) {
                    $this->message = "No es posible utilizar el coreo " . $this->email . ", ya está siendo utilizado por " . $externaluser->getFullNameUpperAttribute();
                }
                }
            }
        }

        return view('livewire.prof-agenda.external-employee-data',compact('externaluser','communes'));
    }
}

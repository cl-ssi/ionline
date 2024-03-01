<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;
use App\Models\ClCommune;
use App\User;
use App\Models\ProfAgenda\OpenHour;

class EmployeeData extends Component
{
    public $user_id = 0;
    public $dv;
    public $email;
    public $message;
    public $flag_more_than_3_faults = false;

    // public function mount(){
    //     dd($this->user_id);
    // }

    protected $listeners = ['loadUserData' => 'loadUserData'];

    public function loadUserData(User $User){
        $this->user_id = $User->id;
        $this->dv = $User->dv;
        $this->render();
    }

    public function render()
    {
        $communes = ClCommune::orderBy('name', 'ASC')->get();
        $user = new User();

        $this->message = "";
        if ($this->user_id > 3000000) {
            $user = User::find($this->user_id);
            $this->emit('renderFromEmployeeData');

            // validación para verificar funcionarios con 3 faltas consecutivas en los ultimos 2 meses
            $twoMonthsAgo = now()->subMonths(2);
            $openHours = OpenHour::where('patient_id',$user->id)
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

            // validación datos de usuario
            if ($user) {
                $this->email = $user->email;
            }else{
                // validación correo
                if ($this->email != null) {
                $user = User::where('email',$this->email)->first();
                if ($user != null) {
                    $this->message = "No es posible utilizar el coreo " . $this->email . ", ya está siendo utilizado por " . $user->getFullNameUpperAttribute();
                }
                }
            }
        }

        return view('livewire.prof-agenda.employee-data',compact('user','communes'));
    }
}

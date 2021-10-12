<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\Country;
use App\User;
use App\Models\Parameters\Bank;

class EmployeeData extends Component
{
    public $user_id = 0;
    public $email;

    public function render()
    {
        $banks = Bank::all();
        $countries = Country::orderBy('name', 'ASC')->get();
        $user = new User();

        // // validación correo
        // if ($this->email != null) {
        //   $user = User::where('email',$this->email)->first();
        //   if ($user != null) {
        //     dd("No es posible utilizar el coreo " . $this->email . ", ya está siendo utilizado por " . $user->getFullNameUpperAttribute());
        //   }
        // }

        if ($this->user_id > 3000000) {
          $user = User::find($this->user_id);
        }

        return view('livewire.service-request.employee-data',compact('banks','user','countries'));
    }
}

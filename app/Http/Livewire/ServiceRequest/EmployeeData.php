<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\Country;
use App\User;
use App\Models\Parameters\Bank;

class EmployeeData extends Component
{
    public $user_id = 0;

    public function render()
    {
        $banks = Bank::all();
        $countries = Country::orderBy('name', 'ASC')->get();
        $user = new User();

        if ($this->user_id > 3000000) {
          $user = User::find($this->user_id);
        }

        return view('livewire.service-request.employee-data',compact('banks','user','countries'));
    }
}

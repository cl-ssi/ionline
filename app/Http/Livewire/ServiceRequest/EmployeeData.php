<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\Parameters\Bank;

class EmployeeData extends Component
{
    public $var = 0;

    public function render()
    {
        $var = $this->var;
        $ServiceRequest = new ServiceRequest();
        $banks = Bank::all();
        
        if ($var > 3000000) {
          $ServiceRequest = ServiceRequest::where('rut','like',$var.'%')->whereNotNull('address')->first();
          // dd($ServiceRequest);
        }

        return view('livewire.service-request.employee-data',compact('ServiceRequest','banks'));
    }
}

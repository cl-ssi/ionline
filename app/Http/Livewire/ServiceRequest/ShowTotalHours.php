<?php

namespace App\Http\Livewire\ServiceRequest;

use Carbon\Carbon;
use Livewire\Component;

class ShowTotalHours extends Component
{
    public $serviceRequest;
    public $totalHoursDay;
    public $totalHoursNight;


    public function render()
    {
        foreach ($this->serviceRequest->shiftControls as $shiftControl) {

//            $nightShiftStart = '21:00:00';
//            $nightShiftend = '08:00:00';
//
//            dd($shiftControl->start_date->toTimeString());



            $this->totalHoursDay = $this->totalHoursDay + $shiftControl->end_date->diffInHours($shiftControl->start_date);
        }

        return view('livewire.service-request.show-total-hours');
    }
}

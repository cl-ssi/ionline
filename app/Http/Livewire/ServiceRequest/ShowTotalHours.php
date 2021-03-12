<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Models\ServiceRequests\Value;
use Carbon\Carbon;
use Livewire\Component;

class ShowTotalHours extends Component
{
    public $serviceRequest;
    public $totalHoursDay;
    public $totalHoursNight;
    public $totalHours;
    public $totalAmount;
    public $errorMsg;

    public function render()
    {
        $value = Value::where('contract_type', $this->serviceRequest->program_contract_type)
            ->where('work_type', $this->serviceRequest->working_day_type)
            ->where('type', $this->serviceRequest->type)
            ->where('estate', $this->serviceRequest->estate)
            ->whereDate('validity_from', '<=', now())->first();

        if (!$value) {
            $this->errorMsg = "No se encuentra valor Hora/Jornada vigente para la solicitud de servicio";
            return view('livewire.service-request.show-total-hours');
        }

        foreach ($this->serviceRequest->shiftControls as $shiftControl) {
            $hoursDay =  $shiftControl->start_date->diffInHoursFiltered(
                function ($date) {
                    if (in_array($date->hour, [8,9,10,11,12,13,14,15,16,17,18,19,20]))
                        return true;
                    else return false;
                }, $shiftControl->end_date);

            $hoursNight =  $shiftControl->start_date->diffInHoursFiltered(
                    function ($date) {
                        if (in_array($date->hour, [21,22,23,0,1,2,3,4,5,6,7]))
                            return true;
                        else return false;
                    }, $shiftControl->end_date);

//            dump('dia: '.$hoursDay);
//            dump('Noche: '.$hoursNight);

            $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
            $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
        }

        $this->totalHours = $this->totalHoursDay + $this->totalHoursNight;
        $this->totalAmount = $this->totalHours * $value->amount;

//        dump('Horas totales dia: '.$this->totalHoursDay);
//        dump('Horas totales noche: '.$this->totalHoursNight);

        return view('livewire.service-request.show-total-hours');
    }
}

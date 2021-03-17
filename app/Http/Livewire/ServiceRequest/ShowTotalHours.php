<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Holiday;
use App\Models\ServiceRequests\Value;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTotalHours extends Component
{
    public $serviceRequest;
    public $fulfillment;
    public $totalHoursDay;
    public $totalHoursNight;
    public $totalHours;
    public $totalAmount;
    public $errorMsg;
    public $refundHours;

    public function render()
    {
        if (!$this->serviceRequest) {
            $this->serviceRequest = $this->fulfillment->serviceRequest;
        }

        $value = Value::where('contract_type', $this->serviceRequest->program_contract_type)
            ->where('work_type', $this->serviceRequest->working_day_type)
            ->where('type', $this->serviceRequest->type)
            ->where('estate', $this->serviceRequest->estate)
            ->whereDate('validity_from', '<=', now())->first();

        if (!$value) {
            $this->errorMsg = "No se encuentra valor Hora/Jornada vigente para la solicitud de servicio:
            Tipo de Contrato: {$this->serviceRequest->program_contract_type}
            , Tipo: {$this->serviceRequest->type}
            , Jornada: {$this->serviceRequest->working_day_type}
            , Estamento: {$this->serviceRequest->estate}";
            return view('livewire.service-request.show-total-hours');
        }

        switch ($this->serviceRequest->working_day_type) {
            case 'HORA MÉDICA':
                foreach ($this->fulfillment->fulfillmentItems as $fulfillmentItem) {
                    $hoursDay = $fulfillmentItem->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]))
                                return true;
                            else return false;
                        }, $fulfillmentItem->end_date);

                    $hoursNight = $fulfillmentItem->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7]))
                                return true;
                            else return false;
                        }, $fulfillmentItem->end_date);

                    if (Auth::user()->can('be god')) {
                        dump("{$fulfillmentItem->start_date} - {$fulfillmentItem->end_date} | dia: $hoursDay | Noche: $hoursNight");
                    }

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
                }

                $this->totalHours = $this->totalHoursDay + $this->totalHoursNight;
                $this->totalAmount = $this->totalHours * $value->amount;
                break;
            case 'TERCER TURNO':
            case 'CUARTO TURNO':
            case 'DIURNO':
            case 'TERCER TURNO - MODIFICADO':
            case 'CUARTO TURNO - MODIFICADO':
            case 'HORA EXTRA':
            case 'TURNO EXTRA':
            case 'OTRO':
                foreach ($this->serviceRequest->shiftControls as $shiftControl) {
                    $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7]))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    if (Auth::user()->can('be god')) {
                        dump("{$shiftControl->start_date} - {$shiftControl->end_date} | dia: $hoursDay | Noche: $hoursNight");
                    }

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
                }

                $this->totalHours = $this->totalHoursDay + $this->totalHoursNight;
                $this->totalAmount = $this->totalHours * $value->amount;
                break;
            case 'DIURNO PASADO A TURNO':
                foreach ($this->serviceRequest->shiftControls as $shiftControl) {
                    $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7]))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    if ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0) {
                        $hoursNight = $hoursNight + $hoursDay;
                        $hoursDay = 0;
                    }

                    if (Auth::user()->can('be god')) {
                        dump("{$shiftControl->start_date} - {$shiftControl->end_date} | dia Semana: {$shiftControl->start_date->dayOfWeek} | dia: $hoursDay | Noche: $hoursNight");
                    }

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
                }


                $firstDayOfMonth = $this->serviceRequest->shiftControls->first()->start_date->firstOfMonth();
                $lastOfMonth = $this->serviceRequest->shiftControls->first()->start_date->lastOfMonth();

                $holidays = Holiday::whereYear('date', '=', $firstDayOfMonth->year)
                    ->whereMonth('date', '=', $firstDayOfMonth->month)
                    ->get();

                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->formattedDate);
                }

                $businessDays = $firstDayOfMonth->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                    return $date->isWeekday() && !in_array($date, $holidaysArray);
                }, $lastOfMonth);

                $workingHoursInMonth = $businessDays * 8.8;
                $this->refundHours = round(($workingHoursInMonth - $this->totalHoursDay), 0);
                $this->totalHours = $this->refundHours + $this->totalHoursNight;
                $totalAmountNight = $this->totalHoursNight * ($value->amount * 1.5);
                $totalAmountDayRefund = $this->refundHours * $value->amount;
                $this->totalAmount = $totalAmountNight - $totalAmountDayRefund;
                break;
        }
        return view('livewire.service-request.show-total-hours');
    }
}

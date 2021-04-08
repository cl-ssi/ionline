<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Holiday;
use App\Models\ServiceRequests\Value;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
    public $hoursDetailArray = array();
    public $forCertificate = false;

    public function render()
    {
        if (!$this->serviceRequest) {
            $this->serviceRequest = $this->fulfillment->serviceRequest;
        }

        //TODO HORA MÉDICA ya no obtiene el valor hora de value
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

                if (!$this->fulfillment) {
                  return view('livewire.service-request.show-total-hours');
                }

                foreach ($this->fulfillment->fulfillmentItems as $keyFulfillment => $fulfillmentItem) {
                    $hoursDayString = $fulfillmentItem->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]))
                                return true;
                            else return false;
                        }, $fulfillmentItem->end_date);

                    $hoursNightString = $fulfillmentItem->start_date->diffInHoursFiltered(
                        function ($date) {
                            if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7]))
                                return true;
                            else return false;
                        }, $fulfillmentItem->end_date);

                    if (Auth::user()->can('be god')) {
                        dump("{$fulfillmentItem->start_date} - {$fulfillmentItem->end_date} | dia: $hoursDayString | Noche: $hoursNightString");
                    }

//                    $this->hoursDetailArray[$keyFulfillment]['type'] = $fulfillmentItem->type;
//                    $this->hoursDetailArray[$keyFulfillment]['start_date'] = $fulfillmentItem->start_date->format('d-m-Y H:i');
//                    $this->hoursDetailArray[$keyFulfillment]['end_date'] = $fulfillmentItem->end_date->format('d-m-Y H:i');
//                    $this->hoursDetailArray[$keyFulfillment]['hours_day'] = $hoursDayString;
//                    $this->hoursDetailArray[$keyFulfillment]['hours_night'] = $hoursNightString;
//                    $this->hoursDetailArray[$keyFulfillment]['observation'] = $fulfillmentItem->observation;

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDayString;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNightString;

//                    dump($this->hoursDetailArray);
                }

                $this->totalHours = $this->totalHoursDay + $this->totalHoursNight;
                $this->totalAmount = $this->totalHours * $this->serviceRequest->gross_amount;
                break;
            case 'TERCER TURNO':
            case 'CUARTO TURNO':
            case 'DIURNO':
            case 'TERCER TURNO - MODIFICADO':
            case 'CUARTO TURNO - MODIFICADO':
            case 'HORA EXTRA':
            case 'TURNO EXTRA':
            case 'OTRO':

                $totalMinutes = 0;
                $totalMinutesDay = 0;
                $totalMinutesNight = 0;
                foreach ($this->serviceRequest->shiftControls as $keyShiftControl => $shiftControl) {
                    $period = new CarbonPeriod($shiftControl->start_date, '1 minute', $shiftControl->end_date);
                    $minutesDay = 0;
                    $minutesNight = 0;
                    foreach ($period as $key => $minute) {
                        if ($key != 0) {
                            if ($minute->format('H:i:s') >= '08:00:00' && $minute->format('H:i:s') <= '20:59:00') {
                                $minutesDay = $minutesDay + 1;
                            } else {
                                $minutesNight = $minutesNight + 1;
                            }
                        }
                    }

                    $hoursDayString = sprintf('%d:%02d', intdiv($minutesDay, 60), ($minutesDay % 60));
                    $hoursNightString = sprintf('%d:%02d', intdiv($minutesNight, 60), ($minutesNight % 60));
                    $this->hoursDetailArray[$keyShiftControl]['start_date'] = $shiftControl->start_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['end_date'] = $shiftControl->end_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['hours_day'] = $hoursDayString;
                    $this->hoursDetailArray[$keyShiftControl]['hours_night'] = $hoursNightString;
                    $this->hoursDetailArray[$keyShiftControl]['observation'] = $shiftControl->observation;

                    //Horas noche dia
                    $totalMinutesDay = $totalMinutesDay + $minutesDay;
                    $totalMinutesNight = $totalMinutesNight + $minutesNight;
                    $this->totalHoursDay = sprintf('%d:%02d', intdiv($totalMinutesDay, 60), ($totalMinutesDay % 60));
                    $this->totalHoursNight = sprintf('%d:%02d', intdiv($totalMinutesNight, 60), ($totalMinutesNight % 60));


                    //Calculo total que se ocupa para calcular monto
                    $diffInMinutes = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                    $totalMinutes = $totalMinutes + $diffInMinutes;
                }

                $this->totalHours = floor($totalMinutes / 60);
                $this->totalAmount = $this->totalHours * $value->amount;
                break;
            case 'DIURNO PASADO A TURNO':
                $holidays = Holiday::whereYear('date', '=', $this->serviceRequest->start_date->year)
                    ->whereMonth('date', '=', $this->serviceRequest->start_date->month)
                    ->get();

                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->date);
                }

                foreach ($this->serviceRequest->shiftControls as $keyShiftControl => $shiftControl) {
                    $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) use ($holidaysArray) {
                            if (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) use ($holidaysArray) {
                            if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                                (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($date->dayOfWeek == 6 || $date->dayOfWeek == 0 || in_array($date->toDateString(), $holidaysArray))))
                                return true;
                            else return false;
                        }, $shiftControl->end_date);

                    $this->hoursDetailArray[$keyShiftControl]['start_date'] = $shiftControl->start_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['end_date'] = $shiftControl->end_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['hours_day'] = $hoursDay;
                    $this->hoursDetailArray[$keyShiftControl]['hours_night'] = $hoursNight;
                    $this->hoursDetailArray[$keyShiftControl]['observation'] = $shiftControl->observation;
                    $this->hoursDetailArray[$keyShiftControl]['is_start_date_holiday'] = $shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString() , $holidaysArray);
                    $this->hoursDetailArray[$keyShiftControl]['is_end_date_holiday'] = $shiftControl->end_date->dayOfWeek == 6 || $shiftControl->end_date->dayOfWeek == 0 || in_array($shiftControl->end_date->toDateString() , $holidaysArray);

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
                }

                $businessDays = $this->serviceRequest->start_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                    return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                }, $this->serviceRequest->end_date);

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

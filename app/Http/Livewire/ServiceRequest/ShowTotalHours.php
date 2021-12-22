<?php

namespace App\Http\Livewire\ServiceRequest;

use App\Holiday;
// use App\Models\ServiceRequests\Value;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\FulfillmentItem;
use Livewire\Component;

class ShowTotalHours extends Component
{
    public $fulfillment;
    public $totalHoursDay;
    public $totalHoursNight;
    public $totalHours;
    public $totalHoursContab;
    public $totalAmount;
    public $errorMsg;
    public $refundHours;
    public $hoursDetailArray = array();
    public $forCertificate = false;
    //public $flag = null;

    //    protected $listeners = ['listener_shift_control'];
    //
    //    public function listener_shift_control()
    //    {
    //      $this->fulfillment = Fulfillment::find($this->fulfillment->id);
    //    }

    public function render()
    {
        //TODO HORA MÉDICA ya no obtiene el valor hora de value
        $value = $this->fulfillment->serviceRequest->net_amount;
        // if( $this->fulfillment->serviceRequest->type == 'Covid' )
        // {
        // $value = Value::where('contract_type', $this->fulfillment->serviceRequest->program_contract_type)
        //     ->where('work_type', $this->fulfillment->serviceRequest->working_day_type)
        //     ->where('type', $this->fulfillment->serviceRequest->type)
        //     ->where('estate', $this->fulfillment->serviceRequest->estate)
        //     ->whereDate('validity_from', '<=', now())->first();
        // }
        //
        // if (!$value) {
        //     $this->errorMsg = "No se encuentra valor Hora/Jornada vigente para la solicitud de servicio:
        //     Tipo de Contrato: {$this->fulfillment->serviceRequest->program_contract_type}
        //     , Tipo: {$this->fulfillment->serviceRequest->type}
        //     , Jornada: {$this->fulfillment->serviceRequest->working_day_type}
        //     , Estamento: {$this->fulfillment->serviceRequest->estate}";
        //     return view('livewire.service-request.show-total-hours');
        // }

        switch ($this->fulfillment->serviceRequest->working_day_type) {
            case 'HORA MÉDICA':

                if (!$this->fulfillment) {
                    return view('livewire.service-request.show-total-hours');
                }

                foreach ($this->fulfillment->shiftControls as $keyFulfillment => $shiftControl) {

                    // $hoursDayString = $shiftControl->start_date->diffInHoursFiltered(
                    //     function ($date) {
                    //         if (in_array($date->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]))
                    //             return true;
                    //         else return false;
                    //     },
                    //     $shiftControl->end_date
                    // );

                    $hoursDayString = 0;
                    $start_hour = $shiftControl->start_date;
                    while ($start_hour < $shiftControl->end_date) {
                      if (in_array($start_hour->hour, [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])) {
                        $hoursDayString = $hoursDayString + 1;
                        // print_r($start_hour);
                      }
                      $start_hour = $start_hour->addMinute();

                    }
                    $hoursDayString = $hoursDayString/60;

                    // $hoursNightString = $shiftControl->start_date->diffInHoursFiltered(
                    //     function ($date) {
                    //         if (in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7]))
                    //             return true;
                    //         else return false;
                    //     },
                    //     $shiftControl->end_date
                    // );

                    $hoursNightString = 0;
                    $start_hour = $shiftControl->start_date;
                    while ($start_hour < $shiftControl->end_date) {
                      if (in_array($start_hour->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6, 7])) {
                        $hoursNightString = $hoursNightString + 1;
                      }
                      $start_hour = $start_hour->addMinute();
                    }
                    $hoursNightString = ($hoursNightString)/60;



                    //                    if (Auth::user()->can('be god')) {
                    //                        dump("{$shiftControl->start_date} - {$shiftControl->end_date} | dia: $hoursDayString | Noche: $hoursNightString");
                    //                    }

                    //                    $this->hoursDetailArray[$keyFulfillment]['type'] = $fulfillmentItem->type;
                    //                    $this->hoursDetailArray[$keyFulfillment]['start_date'] = $fulfillmentItem->start_date->format('d-m-Y H:i');
                    //                    $this->hoursDetailArray[$keyFulfillment]['end_date'] = $fulfillmentItem->end_date->format('d-m-Y H:i');
                    //                    $this->hoursDetailArray[$keyFulfillment]['hours_day'] = $hoursDayString;
                    //                    $this->hoursDetailArray[$keyFulfillment]['hours_night'] = $hoursNightString;
                    //                    $this->hoursDetailArray[$keyFulfillment]['observation'] = $fulfillmentItem->observation;

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDayString;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNightString;
                }


                $this->totalHours = $this->totalHoursDay + $this->totalHoursNight;
                $this->totalHoursContab = floor($this->totalHoursDay + $this->totalHoursNight);
                $this->totalAmount = $this->totalHours * $this->fulfillment->serviceRequest->gross_amount;
                break;

            case 'TERCER TURNO':
            case 'CUARTO TURNO':
            case 'DIURNO':
            case 'TERCER TURNO - MODIFICADO':
            case 'CUARTO TURNO - MODIFICADO':
            case ($this->fulfillment->serviceRequest->working_day_type == 'HORA EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) < Carbon::parse('01-10-2021 00:00'))):
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) < Carbon::parse('01-10-2021 00:00'))):
            case 'OTRO':
                $totalMinutes = 0;
                $totalMinutesDay = 0;
                $totalMinutesNight = 0;
                foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                    $period = new CarbonPeriod($shiftControl->start_date, '1 minute', $shiftControl->end_date);
                    $minutesDay = 0;
                    $minutesNight = 0;
                    foreach ($period as $key => $minute) {
                        if ($key != 0) {
                            //if ($minute->format('H:i:s') >= '08:00:00' && $minute->format('H:i:s') <= '21:00:00') {
                            if ($minute->format('H:i') >= '08:01' && $minute->format('H:i') <= '21:00') {
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
                // if( $this->fulfillment->serviceRequest->type == 'Covid' )
                // {
                //     $this->totalAmount = $this->totalHours * $value->amount;
                // }
                // else
                // {
                //     $this->totalAmount = $this->totalHours * $value;
                //
                // }
                $this->totalAmount = $this->totalHours * $value;
                break;

            case ($this->fulfillment->serviceRequest->working_day_type == 'HORA EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-10-2021 00:00'))):
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-10-2021 00:00'))):
              $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                  ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                  ->get();

              $holidaysArray = array();
              foreach ($holidays as $holiday) {
                  array_push($holidaysArray, $holiday->date);
              }
              // dd($holidays);

              foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                  $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                      function ($date) use ($holidaysArray) {
                          if (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray))
                              return true;
                          else return false;
                      },
                      $shiftControl->end_date
                  );

                  $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                      function ($date) use ($holidaysArray) {
                          if (
                              in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                              (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($date->dayOfWeek == 6 || $date->dayOfWeek == 0 || in_array($date->toDateString(), $holidaysArray)))
                          )
                              return true;
                          else return false;
                      },
                      $shiftControl->end_date
                  );

                  $this->hoursDetailArray[$keyShiftControl]['start_date'] = $shiftControl->start_date->format('d-m-Y H:i');
                  $this->hoursDetailArray[$keyShiftControl]['end_date'] = $shiftControl->end_date->format('d-m-Y H:i');
                  $this->hoursDetailArray[$keyShiftControl]['hours_day'] = $hoursDay;
                  $this->hoursDetailArray[$keyShiftControl]['hours_night'] = $hoursNight;
                  $this->hoursDetailArray[$keyShiftControl]['observation'] = $shiftControl->observation;
                  $this->hoursDetailArray[$keyShiftControl]['is_start_date_holiday'] = $shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray);
                  $this->hoursDetailArray[$keyShiftControl]['is_end_date_holiday'] = $shiftControl->end_date->dayOfWeek == 6 || $shiftControl->end_date->dayOfWeek == 0 || in_array($shiftControl->end_date->toDateString(), $holidaysArray);

                  $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                  $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
              }
              // dd($this->totalHoursDay);
              $totalAmountDayRefund = $this->totalHoursDay * $value;
              $totalAmountNight = $this->totalHoursNight * $value * 1.5;
              $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);

              $this->totalHoursDay = $this->totalHoursDay . " x " . $value;
              $this->totalHoursNight = $this->totalHoursNight . " x 1.5 x " . $value;

              break;


            case 'DIURNO PASADO A TURNO':
                $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                    ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                    ->get();

                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->date);
                }
                // dd($holidays);

                foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                    $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) use ($holidaysArray) {
                            if (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray))
                                return true;
                            else return false;
                        },
                        $shiftControl->end_date
                    );

                    $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                        function ($date) use ($holidaysArray) {
                            if (
                                in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                                (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($date->dayOfWeek == 6 || $date->dayOfWeek == 0 || in_array($date->toDateString(), $holidaysArray)))
                            )
                                return true;
                            else return false;
                        },
                        $shiftControl->end_date
                    );

                    $this->hoursDetailArray[$keyShiftControl]['start_date'] = $shiftControl->start_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['end_date'] = $shiftControl->end_date->format('d-m-Y H:i');
                    $this->hoursDetailArray[$keyShiftControl]['hours_day'] = $hoursDay;
                    $this->hoursDetailArray[$keyShiftControl]['hours_night'] = $hoursNight;
                    $this->hoursDetailArray[$keyShiftControl]['observation'] = $shiftControl->observation;
                    $this->hoursDetailArray[$keyShiftControl]['is_start_date_holiday'] = $shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray);
                    $this->hoursDetailArray[$keyShiftControl]['is_end_date_holiday'] = $shiftControl->end_date->dayOfWeek == 6 || $shiftControl->end_date->dayOfWeek == 0 || in_array($shiftControl->end_date->toDateString(), $holidaysArray);

                    $this->totalHoursDay = $this->totalHoursDay + $hoursDay;
                    $this->totalHoursNight = $this->totalHoursNight + $hoursNight;
                }
                // dd($this->hoursDetailArray);

                $businessDays = $this->fulfillment->serviceRequest->start_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                    return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                }, $this->fulfillment->serviceRequest->end_date);
                // $businessDays = $businessDays+1;
                // dd($businessDays);

                //$prueba = $this->fulfillment->serviceRequest->start_date->diffInDays()

                $daysInMonth = $this->fulfillment->serviceRequest->start_date->daysInMonth;

                //dd($daysInMonth);


                $fulfilmentitems = FulfillmentItem::where('fulfillment_id', $this->fulfillment->id)->get();
                $daysnotworking = 0;
                foreach ($fulfilmentitems as $fulfilmentitem) {
                    $daysnotworking = ($daysnotworking + $fulfilmentitem->start_date->diffInDays($fulfilmentitem->end_date) + 1);
                }

                $totalpermisos = $fulfilmentitems->count();





                if (!$fulfilmentitems->isEmpty()) {
                    //dd('no soy vacio');
                    $daysavg = 0;
                    if ($totalpermisos == 1)
                    {

                        $daysavgpart1 = $this->fulfillment->serviceRequest->start_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                            return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                        }, $fulfilmentitem->start_date);

                        $daysavgpart2 = $fulfilmentitem->end_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                            return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                        }, $this->fulfillment->serviceRequest->end_date);

                        $daysavg = $daysavgpart1 + $daysavgpart2;

                    }
                    else if ($totalpermisos == 2)
                    {
                        $daysavgpart1 = $this->fulfillment->serviceRequest->start_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                            return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                        }, $fulfilmentitems[0]->start_date);

                        $daymiddle = $fulfilmentitems[0]->end_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                            return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                        }, $fulfilmentitems[1]->start_date);

                        $daysavgpart2 = $fulfilmentitems[1]->end_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysArray) {
                            return $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray);
                        }, $this->fulfillment->serviceRequest->end_date);



                        //siempre se le resta 1 ya que finalizar en las 00:00 en vez de las 23:59
                        $daysavgpart2 = $daysavgpart2-1;

                        $daysavg = $daysavgpart1+ $daymiddle + $daysavgpart2;
                        //dd($daysavg);



                    }
                }




                $workingHoursInMonth = 0;
                // dd($daysavg);
                if (isset($daysavg)) {
                    $workingHoursInMonth = $daysavg * 8.8;
                } else {
                    $workingHoursInMonth = $businessDays * 8.8;
                }
                // dd($businessDays);


                $this->refundHours = round(($workingHoursInMonth - $this->totalHoursDay), 0);
                $this->totalHours = $this->refundHours + $this->totalHoursNight;

                // $totalAmountNight = $this->totalHoursNight * ($value->amount * 1.5);
                // $totalAmountDayRefund = $this->refundHours * $value->amount;
                // dd($this->totalHoursNight, $this->refundHours);

                $totalAmountNight = $this->totalHoursNight * $value;
                $totalAmountDayRefund = $this->refundHours * $value / 1.5;

                $this->totalAmount = ($totalAmountNight - $totalAmountDayRefund);
                break;
        }
        return view('livewire.service-request.show-total-hours');
    }
}

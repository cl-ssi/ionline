<?php

namespace App\Livewire\ServiceRequest;

use App\Models\Parameters\Holiday;
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
    public $forResolution = false;
    public $totalHoursDayString;
    public $totalHoursNightString;
    //public $flag = null;

    public function formatHours($decimalHours)
    {
        if (is_numeric($decimalHours)) {
            $hours = floor($decimalHours); // Parte entera de las horas
            $minutes = round(($decimalHours - $hours) * 60); // Convertir la parte decimal a minutos
            return "{$hours} hrs y {$minutes} minutos";
        }

        // Si no es un número entero o decimal, devolver el valor tal como está
        return $decimalHours;
    }

    public function render()
    {
        /* TODO: HORA MÉDICA ya no obtiene el valor hora de value */
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
            case 'TURNO DE REEMPLAZO':

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



                    //                    if (auth()->user()->can('be god')) {
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

                $this->totalHours = round($this->totalHoursDay + $this->totalHoursNight, 0, PHP_ROUND_HALF_UP);
                $this->totalHoursContab = floor($this->totalHours);
                $this->totalAmount = $this->totalHoursContab * $this->fulfillment->serviceRequest->gross_amount;

                break;
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' &&
                  $this->fulfillment->serviceRequest->responsability_center_ou_id == 138 &&
                  (($this->fulfillment->serviceRequest->start_date >= '2021/11/01 00:00') && ($this->fulfillment->serviceRequest->end_date <= '2021/12/31 23:59:59'))):
                $totalMinutes = 0;
                $totalMinutesDay = 0;
                $totalMinutesNight = 0;
                foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                    $period = new CarbonPeriod($shiftControl->start_date, '1 minute', $shiftControl->end_date);
                    $minutesDay = 0;
                    $minutesNight = 0;
                    foreach ($period as $key => $minute) {
                        if ($key != 0) {
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
                $this->totalAmount = $this->totalHours * $value;
                break;

            case 'TERCER TURNO':
            case 'CUARTO TURNO':
            case 'DIURNO':
            case 'TERCER TURNO - MODIFICADO':
            case 'CUARTO TURNO - MODIFICADO':
            // case 'TURNO DE REEMPLAZO':
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

            // solicitado por nataly el 06/04/2022: independiente que sea del 2021, necesita que se obtenga el valor con el fomato 2022
            case $this->fulfillment->serviceRequest->id == 11872:

                $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                    ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                    ->get();

                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->date->toDateString());
                }

                $total_minutes = 0;
                foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                    $hoursDay = 0;
                    if (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) &&
                        $shiftControl->start_date->isWeekday() &&
                        !in_array($shiftControl->start_date->toDateString(), $holidaysArray))
                    {
                          if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                            $minutesDay = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                            $total_minutes = $total_minutes + $minutesDay;
                            $hoursDay = round($minutesDay/60,2);
                          }
                    }
                    $hoursNight = 0;
                    if (in_array($shiftControl->start_date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                       (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray)))) {
                          if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                            $minutesNight = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                            $total_minutes = $total_minutes + $minutesNight;
                            $hoursNight = round($minutesNight/60,2);
                          }
                    }

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

                if ($this->fulfillment->serviceRequest->programm_name == 'OTROS PROGRAMAS HETG' or $this->fulfillment->serviceRequest->programm_name == 'LEQ Fonasa') {
                  $totalAmountDayRefund = floor($this->totalHoursDay) * $value;
                  $totalAmountNight = floor($this->totalHoursNight) * $value * 1.2;
                  $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);
                }else{
                  $this->totalAmount = floor($total_minutes/60) * $value;
                }
                break;

            case ($this->fulfillment->serviceRequest->working_day_type == 'HORA EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-10-2021 00:00'))
                                                                                       && (Carbon::parse('31-'. $this->fulfillment->month ."-". $this->fulfillment->year) <= Carbon::parse('31-12-2021 00:00'))):
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-10-2021 00:00'))
                                                                                        && (Carbon::parse('31-'. $this->fulfillment->month ."-". $this->fulfillment->year) <= Carbon::parse('31-12-2021 00:00'))):

              $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                  ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                  ->get();

              $holidaysArray = array();
              foreach ($holidays as $holiday) {
                  array_push($holidaysArray, $holiday->date->toDateString());
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

              //cuando es servicio de emergencia hospitalaria, no se multiplica por 1.5
              if ($this->fulfillment->serviceRequest->responsability_center_ou_id == 138) {
                $totalAmountNight = $this->totalHoursNight * $value;
              }else{
                $totalAmountNight = $this->totalHoursNight * $value * 1.5;
              }

              $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);
              $this->totalHoursDay = $this->totalHoursDay . " x " . $value;

              //cuando es servicio de emergencia hospitalaria, no se multiplica por 1.5
              if ($this->fulfillment->serviceRequest->responsability_center_ou_id == 138) {
                $this->totalHoursNight = $this->totalHoursNight . " x " . $value;
              }else{
                $this->totalHoursNight = $this->totalHoursNight . " x 1.5 x " . $value;
              }


              break;

            // 14/02/2022: nataly solicita que desde enero del 2022, no se incluya la multiplicación de 1.5 para horarios nocturnos
            // 15/09/2022: modificación, solo debe aplicar hasta fines de abril.
            case ($this->fulfillment->serviceRequest->working_day_type == 'HORA EXTRA'  && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-01-2022 00:00'))
                                                                                        && (Carbon::parse('30-'. $this->fulfillment->month ."-". $this->fulfillment->year) <= Carbon::parse('30-04-2022 00:00'))):
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-01-2022 00:00'))
                                                                                        && (Carbon::parse('30-'. $this->fulfillment->month ."-". $this->fulfillment->year) <= Carbon::parse('30-04-2022 00:00'))):
              // programas covid: valor unico (solo hora extra)
              // otros programas hospital/todo el resto: nocturno y diruno

              $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                  ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                  ->get();

              $holidaysArray = array();
              foreach ($holidays as $holiday) {
                  array_push($holidaysArray, $holiday->date->toDateString());
              }

              $total_minutes = 0;
              foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {
                  // $hoursDay = $shiftControl->start_date->diffInHoursFiltered(
                  //     function ($date) use ($holidaysArray) {
                  //         if (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && $date->isWeekday() && !in_array($date->toDateString(), $holidaysArray))
                  //             return true;
                  //         else return false;
                  //     },
                  //     $shiftControl->end_date
                  // );
                  $hoursDay = 0;
                  if (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) &&
                      $shiftControl->start_date->isWeekday() &&
                      !in_array($shiftControl->start_date->toDateString(), $holidaysArray)) {
                        if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                          $minutesDay = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                          $total_minutes = $total_minutes + $minutesDay;
                          $hoursDay = round($minutesDay/60,2);
                        }
                  }

                  // $hoursNight = $shiftControl->start_date->diffInHoursFiltered(
                  //     function ($date) use ($holidaysArray) {
                  //         if (
                  //             in_array($date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                  //             (in_array($date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($date->dayOfWeek == 6 || $date->dayOfWeek == 0 || in_array($date->toDateString(), $holidaysArray)))
                  //         )
                  //             return true;
                  //         else return false;
                  //     },
                  //     $shiftControl->end_date
                  // );
                  $hoursNight = 0;
                  if (in_array($shiftControl->start_date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                     (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray)))) {
                        if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                          $minutesNight = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                          $total_minutes = $total_minutes + $minutesNight;
                          $hoursNight = round($minutesNight/60,2);
                        }
                  }

                  // dd($total_minutes);

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

              // $totalAmountDayRefund = $this->totalHoursDay * $value;
              // $totalAmountNight = $this->totalHoursNight * $value;

              // dd($total_minutes);

              // $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);
              if ($this->fulfillment->serviceRequest->programm_name == 'OTROS PROGRAMAS HETG') {
                $totalAmountDayRefund = floor($this->totalHoursDay) * $value;
                $totalAmountNight = floor($this->totalHoursNight) * $value * 1.2;
                $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);
              }else{
                $this->totalAmount = floor($total_minutes/60) * $value;
              }

              // $this->totalHoursDay = $this->totalHoursDay . " x " . $value;
              // $this->totalHoursNight = $this->totalHoursNight . " x " . $value;
              // $this->totalHoursDay = $this->totalHoursDay;
              // $this->totalHoursNight = $this->totalHoursNight;
              break;

            // 15/06/2022: nataly solicita que desde mayo del 2022, se aplique para todos valores diurnos y nocturnos, nocturnos con factor 1.2
            // 05/07/2022: nataly indica que hoy autorizaron que los extras covid y contingencia respiratoria se pague a valor único criterio (sin el 1.2) aplicado hasta agosto del 2022
            case ($this->fulfillment->serviceRequest->working_day_type == 'HORA EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-05-2022 00:00'))):
            case ($this->fulfillment->serviceRequest->working_day_type == 'TURNO EXTRA' && (Carbon::parse('01-'. $this->fulfillment->month ."-". $this->fulfillment->year) >= Carbon::parse('01-05-2022 00:00'))):

                $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                    ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                    ->get();
    
                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->date->toDateString());
                }
    
                $total_minutes = 0;
                foreach ($this->fulfillment->shiftControls as $keyShiftControl => $shiftControl) {

                    //18/01/2023: Solicitado por fabián, solicita que solo para otros programas hospital, se considere el otro cálculo 
                    // if($this->fulfillment->serviceRequest->programm_name == 'OTROS PROGRAMAS HETG'){
                    //     $hoursDayString = 0;
                    //     $start_hour = $shiftControl->start_date;
                    //     while ($start_hour < $shiftControl->end_date) {
                    //         if (in_array($start_hour->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && 
                    //             $shiftControl->start_date->isWeekday() &&
                    //             !in_array($shiftControl->start_date->toDateString(), $holidaysArray)) {
                    //             $hoursDayString = $hoursDayString + 1;
                    //         }
                    //         $start_hour = $start_hour->addMinute();
                    //     }
                    //     $hoursDay = round(($hoursDayString/60),2);

                    //     $hoursNightString = 0;
                    //     $start_hour = $shiftControl->start_date;
                    //     while ($start_hour < $shiftControl->end_date) {
                    //         if (in_array($start_hour->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                    //         ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray))) {
                    //             $hoursNightString = $hoursNightString + 1;
                    //         }
                    //         $start_hour = $start_hour->addMinute();
                    //     }
                    //     $hoursNight = round(($hoursNightString/60),2);

                    // }else{
                        
                    //     $hoursDay = 0;
                    //     if (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) &&
                    //         $shiftControl->start_date->isWeekday() &&
                    //         !in_array($shiftControl->start_date->toDateString(), $holidaysArray)) {
                    //         if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                    //             $minutesDay = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                    //             $total_minutes = $total_minutes + $minutesDay;
                    //             $hoursDay = round($minutesDay/60,2);
                    //         }
                    //     }
        
                    //     $hoursNight = 0;
                    //     if (in_array($shiftControl->start_date->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) ||
                    //         (in_array($shiftControl->start_date->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray)))) {
                    //         if ($shiftControl->start_date->diffInMinutes($shiftControl->end_date) >= 30) {
                    //             $minutesNight = $shiftControl->start_date->diffInMinutes($shiftControl->end_date);
                    //             $total_minutes = $total_minutes + $minutesNight;
                    //             $hoursNight = round($minutesNight/60,2);
                    //         }
                    //     }
                    // }

                    // 17/02/2023: Nataly indica que debe ser el mismo cálculo para ambos casos.
                    // hace la salvedad que en el cálculo con el valor, existen diferencias entre tipos de programas.
                    $hoursDayString = 0;
                        $start_hour = $shiftControl->start_date;
                        while ($start_hour < $shiftControl->end_date) {
                            if (in_array($start_hour->hour, [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]) && $shiftControl->start_date->isWeekday() && !in_array($shiftControl->start_date->toDateString(), $holidaysArray)) {
                                $hoursDayString = $hoursDayString + 1;
                            }
                            $start_hour = $start_hour->addMinute();
                        }
                        $hoursDay = round(($hoursDayString/60),2);

                        $hoursNightString = 0;
                        $start_hour = $shiftControl->start_date;
                        while ($start_hour < $shiftControl->end_date) {
                            if (in_array($start_hour->hour, [21, 22, 23, 0, 1, 2, 3, 4, 5, 6]) || ($shiftControl->start_date->dayOfWeek == 6 || $shiftControl->start_date->dayOfWeek == 0 || in_array($shiftControl->start_date->toDateString(), $holidaysArray))) {
                                $hoursNightString = $hoursNightString + 1;
                            }
                            $start_hour = $start_hour->addMinute();
                        }
                        $hoursNight = round(($hoursNightString/60),2);
                    
    
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
                  
                // 17/08/2023: samantha olivares solicita que si la unidad es Unidad de Movilización, y el valor diurno es mayor a 40, se debe dejar en 40.
                if($this->fulfillment->serviceRequest->responsabilityCenter->id == 122){
                    if($this->totalHoursDay > 40){
                        $this->totalHoursDay = 40;
                    }
                }

                $totalAmountDayRefund = floor($this->totalHoursDay) * $value;
                $totalAmountNight = floor($this->totalHoursNight) * $value;
                $this->totalAmount = ($totalAmountNight + $totalAmountDayRefund);
                
                $this->totalHoursDayString = $this->totalHoursDay;
                $this->totalHoursNightString = $this->totalHoursNight;
                $this->totalHoursDay = $this->totalHoursDay . " x " . $value;
                $this->totalHoursNight = $this->totalHoursNight . " x " . $value;
                // $this->totalHoursDay = $this->totalHoursDay;
                // $this->totalHoursNight = $this->totalHoursNight;
                
                break;

            case 'DIURNO PASADO A TURNO':
                $holidays = Holiday::whereYear('date', '=', $this->fulfillment->serviceRequest->start_date->year)
                    ->whereMonth('date', '=', $this->fulfillment->serviceRequest->start_date->month)
                    ->get();

                $holidaysArray = array();
                foreach ($holidays as $holiday) {
                    array_push($holidaysArray, $holiday->date->toDateString());
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

                //$prueba = (int) $this->fulfillment->serviceRequest->start_date->diffInDays()

                $daysInMonth = $this->fulfillment->serviceRequest->start_date->daysInMonth;

                //dd($daysInMonth);


                $fulfilmentitems = FulfillmentItem::where('fulfillment_id', $this->fulfillment->id)->get();
                $daysnotworking = 0;
                foreach ($fulfilmentitems as $fulfilmentitem) {
                    $daysnotworking = ($daysnotworking + (int) $fulfilmentitem->start_date->diffInDays($fulfilmentitem->end_date) + 1);
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

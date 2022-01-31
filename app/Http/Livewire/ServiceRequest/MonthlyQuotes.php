<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Carbon\Carbon;
// use App\Models\ServiceRequests\Value;
use DatePeriod;
use DateInterval;

class MonthlyQuotes extends Component
{
    public $parametroMes;
    public $array_valores_mensualizados;

    public $serviceRequest;
    public $valores;
    public $resultadoEnNumero = false;
    public $string;


    // funcion que calcula monto considerando inasistencias del período indicado
    public function monto_con_inasistencias($mes_completo, $mes, $monto)
    {
      $fulfillment = $this->serviceRequest->fulfillments->where('month',$mes)->first();

      if ($fulfillment) {
        $total_dias_trabajados = 0;
        $mes_completo = true;

        /* si tiene una "Renuncia voluntaria", el termino del contrato es ahí */
        if ($renuncia = $fulfillment->fulfillmentItems->where('type', 'Renuncia voluntaria')->first()) {
            $fulfillment->end_date = $renuncia->end_date;
        }

        /* si inicio de contrato coincide con inicio de mes y término de contrato coincide con fin de mes */
        if ($fulfillment->start_date and $fulfillment->end_date) {
            if (
                $fulfillment->start_date->toDateString() == $fulfillment->start_date->startOfMonth()->toDateString()
                and $fulfillment->end_date->toDateString() == $fulfillment->end_date->endOfMonth()->toDateString()
            ) {
                $total_dias_trabajados = 30;
                $mes_completo = true;
            }

            /* De lo contrario es la diferencia entre el primer y último día */ else {
                $total_dias_trabajados = $fulfillment->start_date->diff($fulfillment->end_date)->days + 1;
                $mes_completo = false;
            }
        }

        /* Restar las ausencias */
        $dias_descuento = 0;
        $dias_trabajado_antes_retiro = 0;
        $hrs_descuento = 0;
        $mins_descuento = 0;

        foreach ($fulfillment->fulfillmentItems as $item) {
            switch ($item->type) {
                case 'Inasistencia Injustificada':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    break;
                case 'Licencia no covid':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    break;
                case 'Abandono de funciones':
                    $mes_completo = false;
                    $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                    //dd((int)$item->end_date->format("d"));
                    //dd($fulfillment->start_date->format("d"));
                    $dias_trabajado_antes_retiro = ((int)$item->end_date->format("d"))-(int)$fulfillment->start_date->format("d") ;
                    //dd($dias_trabajado_antes_retiro);

                    break;
                case 'Renuncia voluntaria':
                    $mes_completo = false;
                    // evita ocurrir error si no existe end_date
                    if ($item->end_date == null) {
                      $dias_trabajado_antes_retiro = 0;
                      break;
                    }
                    $dias_trabajado_antes_retiro = (int)$item->end_date->format("d") - 1;
                    $dias_descuento += 1;
                    break;
                case 'Término de contrato anticipado':
                        $mes_completo = false;
                        // evita ocurrir error si no existe end_date
                        if ($item->end_date == null) {
                          $dias_trabajado_antes_retiro = 0;
                          break;
                        }
                        $dias_trabajado_antes_retiro = (int)$item->end_date->format("d") - 1;
                        $dias_descuento += 1;
                        //dd('soy termino de contrato');
                        break;
                case 'Atraso':
                    $mes_completo = false;
                    //$hrs_descuento += $item->end_date->diffInHours($item->start_date);
                    $mins_descuento += $item->end_date->diffInMinutes($item->start_date);
                    //dd($hrs_descuento);
                    break;
            }
        }

        $total_dias_trabajados -= $dias_descuento;

        // se verifica si hay retiro para calcular la cantidad de dias trabajados
        if ($mes_completo) {
            $total = $monto - ($dias_descuento * ($monto / 30));
        } else {
            if ($dias_trabajado_antes_retiro == 0) {

            }
            if ($dias_trabajado_antes_retiro != 0) {

                $total_dias_trabajados = $dias_trabajado_antes_retiro;
            }

            // if ($mes == 9) {
            //   dd($monto, $total_dias_trabajados, $monto);
            // }
            $total = $total_dias_trabajados * ($monto / 30);
        }

        if ($hrs_descuento != 0) {
          $valor_hora = ($monto / 30 / 8.8);
          $total_dcto_horas = $hrs_descuento * $valor_hora;
          $total = $total - $total_dcto_horas;
        }

        if ($mins_descuento >= 60) {
            //dd('soy minuto descuento diferente a 0'.$mins_descuento);
            $valor_hora = ($monto / 30 / 8.8);
            $hrs_descuento = floor($mins_descuento/60);
            $total_dcto_horas = $hrs_descuento * $valor_hora;
            $total = $total - $total_dcto_horas;
          }

        return $total;
        // return number_format(round($total), 0, ',', '.');
      }

    }

    public function render()
    {
        // dd('entre aca');
        $serviceRequest = $this->serviceRequest;

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        /* TODO: Que pasa si un contrato pasa al siguiente año? */
        $year = $serviceRequest->start_date->year;

        // se comenta por solicitud de área covid
        // //////////////CALCULO Y RENDERICACIÓN PARA COVID////////////////////////
        // if ($serviceRequest->type == 'Covid') {
        //     // dd('entre en tipo COVID');
        //     //dd('soy auxiliar');
        //
        //     switch ($serviceRequest->estate) {
        //         case 'Profesional Médico':
        //         case 'Farmaceutico':
        //             switch ($serviceRequest->weekly_hours) {
        //                 case '44':
        //                     $estate = 'Médico 44';
        //                     break;
        //                 case '28':
        //                     $estate = 'Médico 28';
        //                     break;
        //                 case '22':
        //                     $estate = 'Médico 22';
        //                     break;
        //                 default:
        //                     /* TODO: No sé que hacer acá */
        //                     $estate = null;
        //                     break;
        //             }
        //             $valor_mensual = optional(
        //                 Value::orderBy('validity_from', 'desc')
        //                     ->where('contract_type', 'Mensual')
        //                     ->where('type', 'covid')
        //                     ->where('establishment_id', $serviceRequest->establishment_id)
        //                     ->where('estate', $estate)
        //                     ->where('work_type', $serviceRequest->working_day_type)
        //                     ->first()
        //             )->amount;
        //             //dd($valor_mensual);
        //             break;
        //         case 'Profesional':
        //
        //             // $valor_mensual = optional(
        //             //     Value::orderBy('validity_from', 'desc')
        //             //         ->where('contract_type', 'Mensual')
        //             //         ->where('type', 'covid')
        //             //         ->where('establishment_id', $serviceRequest->establishment_id)
        //             //         ->where('estate', $serviceRequest->estate)
        //             //         ->where('work_type', $serviceRequest->working_day_type)
        //             //         ->first()
        //             // )->amount;
        //
        //             $valor_mensual = $serviceRequest->net_amount;
        //
        //             switch ($serviceRequest->weekly_hours) {
        //                     // case '33':
        //                     //     $valor_mensual = $valor_mensual * 0.75;
        //                     //     break;
        //                     //     //case '28': $valor_mensual = $valor_mensual * 0.636363; break;
        //                 case '22':
        //                     $valor_mensual = $valor_mensual * 0.5;
        //                     break;
        //                     // case '11':
        //                     //     $valor_mensual = $valor_mensual * 0.25;
        //                     //     break;
        //             }
        //             break;
        //
        //         case 'Técnico':
        //         case 'Administrativo':
        //         case 'Odontólogo':
        //         case 'Bioquímico':
        //         case 'Auxiliar':
        //
        //
        //             // $valor_mensual = optional(
        //             //     Value::orderBy('validity_from', 'desc')
        //             //         ->where('contract_type', 'Mensual')
        //             //         ->where('type', 'covid')
        //             //         ->where('establishment_id', $serviceRequest->establishment_id)
        //             //         ->where('estate', $serviceRequest->estate)
        //             //         ->where('work_type', $serviceRequest->working_day_type)
        //             //         ->first()
        //             // )->amount;
        //             $valor_mensual = $serviceRequest->net_amount;
        //             // dd('soy auxiliar');
        //     }
        //
        //     for ($i = $first_month; $i <= $last_month; $i++) {
        //
        //         $first_day_month = 1;
        //         $last_day_month = Carbon::createFromDate($year, $i, 1)->lastOfMonth()->day;
        //
        //         /* Si es un solo mes */
        //         if ($first_month == $last_month) {
        //             if (
        //                 $serviceRequest->start_date->day == $first_day_month and
        //                 $serviceRequest->end_date->day == $last_day_month
        //             ) {
        //                 /* Mes completo */
        //                 $valores[$i] = $valor_mensual;
        //             } else {
        //                 $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->end_date)->days + 1;
        //                 /* Días trabajados */
        //                 $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
        //             }
        //         }
        //
        //         /* Más de un mes */ else if ($i == $first_month) {
        //             /* Creo que sólo necesito el valor mensual acá, el if y else no deberían ser necesarios */
        //             if ($serviceRequest->start_date->day == $first_day_month) {
        //                 $valores[$i] = $valor_mensual;
        //             } else {
        //                 $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
        //                 /* Días trabajados */
        //                 $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
        //             }
        //         } else if ($i == $last_month) {
        //             if ($serviceRequest->end_date->day == $last_day_month) {
        //                 $valores[$i] = $valor_mensual;
        //             } else {
        //                 $dias_trabajados = $serviceRequest->end_date->diff($serviceRequest->end_date->firstOfMonth())->days + 1;
        //                 /* Días trabajados */
        //                 $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
        //             }
        //         } else {
        //             /* Mes completo porque es el intermedio */
        //             $valores[$i] = $valor_mensual;
        //         }
        //     }
        //
        //     if ($this->resultadoEnNumero) {
        //         $this->valores = $valores;
        //     } else {
        //         $nroCuotas = count($valores);
        //         if ($nroCuotas == 1) {
        //             $string = $nroCuotas . " cuota";
        //             $string .= " de $" . number_format(current($valores)) . " el mes de " . Carbon::create()->day(1)->month(key($valores))->monthName . "; ";
        //         } else {
        //             $string = $nroCuotas . " cuotas";
        //
        //             foreach ($valores as $key => $valor) {
        //                 if ($key === array_key_last($valores)) {
        //                     $string .= " y una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName . "; ";
        //                 } else {
        //                     $string .= ", una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName;
        //                 }
        //             }
        //         }
        //
        //
        //         $this->valores = $string;
        //     }
        // }
        // ////es HONORARIO SUMA ALZADA
        // else {            ///son cuotas iguales
            // $aguinaldo = '';
            // if ($serviceRequest->weekly_hours == 22 or $serviceRequest->weekly_hours == 44 or $serviceRequest->weekly_hours == 11) {
            //
            //     if (!in_array($serviceRequest->id, array(8146, 7925, 8381, 8382, 8384, 8385, 8387)))
            //     {
            //         $aguinaldo = $this->aguinaldopatrias($serviceRequest);
            //     }
            //
            // }

            // obtiene descuentos
            // $serviceRequest


            $valores_mensualizados = array();
            if ($serviceRequest->start_date->format('Y-m-d') == $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') and $serviceRequest->end_date->format('Y-m-d') == $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {

                $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                $valor_mensual = $serviceRequest->net_amount;
                $string = $nroCuotas . " cuotas,";
                $interval = DateInterval::createFromDateString('1 month');
                $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
                $periods = iterator_to_array($periods);
                foreach ($periods as $key => $period) {
                    if ($key === array_key_first($periods)) {
                        $string .= " una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                        $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    } else if ($key === array_key_last($periods)) {
                        $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                        $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    } else {
                        $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                        $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }
                }
            } else
            //son cuotas valores diferentes
            {
                // la persona trabaja menos de 1 mes
                //dd('holita');
                $diff_in_months = $serviceRequest->end_date->diffInMonths($serviceRequest->start_date);
                if ($diff_in_months < 1) {
                    $string = "1 cuota de $";
                    $string .= number_format($serviceRequest->gross_amount);
                    $valores_mensualizados[$serviceRequest->start_date->month] = number_format($this->monto_con_inasistencias(false, $serviceRequest->start_date->month, $serviceRequest->net_amount));

                } else {

                    if ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') and $serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                        $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 2;
                        $valor_mensual = $serviceRequest->net_amount;
                        $string = $nroCuotas . " cuotas,";
                        $interval = DateInterval::createFromDateString('1 month');
                        $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date->addMonth());
                        $periods = iterator_to_array($periods);
                        $dias_trabajados1 = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                        //$valor_diferente1 = round($dias_trabajados1 * round(($valor_mensual / 30)));
                        // se modifica el cálculo según correo
                        $valor_diferente1 = round($dias_trabajados1 * ($valor_mensual / 30));
                        $dias_trabajados2 = $serviceRequest->end_date->firstOfMonth()->diff($serviceRequest->end_date)->days + 1;
                        //dd($dias_trabajados2);
                        $valor_diferente2 = round($dias_trabajados2 * ($valor_mensual / 30));


                        foreach ($periods as $key => $period) {
                            if ($key === array_key_first($periods)) {
                                $string .= " una de $" . number_format($valor_diferente1) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente1));
                            } else if ($key === array_key_last($periods)) {
                                $string .= " y una de $" . number_format($valor_diferente2) . " el mes de " . $period->monthName . ";";
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente2));
                            } else {
                                $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }
                        }
                    } elseif ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d')) {

                        //La Persona no parte a trabajar en un mes cerrado
                        $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                        $valor_mensual = $serviceRequest->net_amount;
                        $string = $nroCuotas . " cuotas,";
                        $interval = DateInterval::createFromDateString('1 month');
                        $periods   = new DatePeriod($serviceRequest->start_date->firstOfMonth(), $interval, $serviceRequest->end_date->endOfMonth());
                        //dd($interval);
                        //dd($periods);
                        $periods = iterator_to_array($periods);
                        //dd($periods);
                        $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                        //$valor_diferente = round($dias_trabajados * round(($valor_mensual / 30)));
                        $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));
                        // dd('entre aca');
                        //dd($periods);
                        //$periods = $periods+1;
                        foreach ($periods as $key => $period) {
                            if ($key === array_key_first($periods)) {
                                $string .= " una de $" . number_format($valor_diferente) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            } else if ($key === array_key_last($periods)) {
                                $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            } else {
                                $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }
                        }
                    }
                    //la persona termina de trabajar en un día que no es fin de mes
                    elseif ($serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                        //dd('entra aca');
                        // dd('entre aca 2');
                        $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                        $valor_mensual = $serviceRequest->net_amount;
                        $string = $nroCuotas . " cuotas,";
                        $interval = DateInterval::createFromDateString('1 month');
                        $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
                        $periods = iterator_to_array($periods);
                        // $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                        //$dias_trabajados = $serviceRequest->end_date->lastOfMonth()->diff($serviceRequest->end_date)->days + 1;
                        $dias_trabajados = (int)$serviceRequest->end_date->format('d');
                        //dd($dias_trabajados);
                        //$valor_diferente = round($dias_trabajados * round(($valor_mensual / 30)));
                        $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));
                        //dd($valor_diferente);

                        foreach ($periods as $key => $period) {
                            if ($key === array_key_first($periods)) {
                                $string .= " una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            } else if ($key === array_key_last($periods)) {
                                $string .= " y una de $" . number_format($valor_diferente) . " el mes de " . $period->monthName . ";";
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            } else {
                                $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                                $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }
                        }
                    }
                }
            }

            // se devuelve array para mostrar monto de un mes determinado por parámetro
            if($this->parametroMes != null){
              // devuelve valor solo si existe en array
              if (array_key_exists($this->parametroMes, $valores_mensualizados)) {
                $this->array_valores_mensualizados = $valores_mensualizados;
              }
            }

            // $string .= $aguinaldo;
            if ($serviceRequest->bonus_indications != null) {
              $string .= ", " . $serviceRequest->bonus_indications . ", ";
            }

            $this->valores = $string;
        // }



        //dd($string);
        return view('livewire.service-request.monthly-quotes');
    }

    public function aguinaldopatrias($serviceRequest)
    {
        //$aguinaldo;
        // dd('entre a aguinaldo');

        $startDate = $serviceRequest->start_date;
        $endDate = $serviceRequest->end_date;
        $septiembre = \Carbon\Carbon::createFromFormat('Y-m-d', '2021-09-1');
        //dd(\Carbon\Carbon::now());
        $check = $septiembre->between($startDate, $endDate);

        if ($check) {

            switch ($serviceRequest->programm_name) {
                case 'PESPI':
                case 'SENDA':
                case 'OTROS PROGRAMAS SSI':
                case 'CHILE CRECE CONTIGO':

                    if ($serviceRequest->net_amount <= 794149) {
                        return (" en la cuota de Septiembre percibirá un aguinaldo de $76.528");
                    } else {

                        switch ($serviceRequest->estate) {
                            case 'Profesional':
                                // dd('entre aca csm');
                                return (" en la cuota de Septiembre percibirá un aguinaldo de $53.124");

                                break;
                            default:
                                /* TODO: No sé que hacer acá */
                                return (" en la cuota de Septiembre percibirá un aguinaldo de $76.528");
                                break;
                        }
                    }
            }
        }
    }
}

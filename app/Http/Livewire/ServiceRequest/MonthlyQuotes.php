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
    public $msg = "";


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



    public function items_verification($month)
    {
      // dd($this->serviceRequest->fulfillments->where('month',$month));
      foreach ($this->serviceRequest->fulfillments->where('month',$month) as $key => $fulfillment) {
          foreach ($fulfillment->fulfillmentItems as $item) {
              switch ($item->type) {
                  case 'Inasistencia Injustificada':
                  case 'Licencia no covid':
                  case 'Abandono de funciones':
                  case 'Atraso':
                    if ($item->end_date == null) {
                      return false;
                      // $this->msg = "Falta fecha de término";
                      // return view('livewire.service-request.monthly-quotes');
                    }
                    if ($item->start_date == null) {
                      return false;
                      // $this->msg = "Falta fecha de inicio";
                      // return view('livewire.service-request.monthly-quotes');
                    }
                  case 'Renuncia voluntaria':
                  case 'Término de contrato anticipado':
                    if ($item->end_date == null) {
                      return false;
                    }
              }
          }
      }
      return true;
    }




    public function render()
    {
        $serviceRequest = $this->serviceRequest;

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        /* TODO: Que pasa si un contrato pasa al siguiente año? */
        $year = $serviceRequest->start_date->year;


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
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                } else if ($key === array_key_last($periods)) {
                    $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                    $this->items_verification($period->month);
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                } else {
                    $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                    if ($this->items_verification($period->month)) {
                      $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                    }else{
                      $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                    }
                }
            }
        } else
        //son cuotas valores diferentes
        {
            // la persona trabaja menos de 1 mes
            $diff_in_months = $serviceRequest->end_date->diffInMonths($serviceRequest->start_date);
            if ($diff_in_months < 1) {
                $string = "1 cuota de $";
                $string .= number_format($serviceRequest->gross_amount);
                if ($this->items_verification($serviceRequest->start_date->month)) {
                  $valores_mensualizados[$serviceRequest->start_date->month] = number_format($this->monto_con_inasistencias(false, $serviceRequest->start_date->month, $serviceRequest->net_amount));
                }else{
                  $valores_mensualizados[$serviceRequest->start_date->month] = "Revise los datos ingresados en el cuadro de responsable.";
                }

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
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente1));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            $string .= " y una de $" . number_format($valor_diferente2) . " el mes de " . $period->monthName . ";";
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente2));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                } elseif ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d')) {

                    //La Persona no parte a trabajar en un mes cerrado
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                    $valor_mensual = $serviceRequest->net_amount;
                    $string = $nroCuotas . " cuotas,";
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date->firstOfMonth(), $interval, $serviceRequest->end_date->endOfMonth());
                    $periods = iterator_to_array($periods);
                    //erg: comenté la linea siguiente porque desconozco el +1 que se hace al final, estaba afectando cálculo de nataly 16/02/2022
                    // $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days;
                    $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            $string .= " una de $" . number_format($valor_diferente) . " el mes de " . $period->monthName;
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                }
                //la persona termina de trabajar en un día que no es fin de mes
                elseif ($serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
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
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else if ($key === array_key_last($periods)) {
                            $string .= " y una de $" . number_format($valor_diferente) . " el mes de " . $period->monthName . ";";
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(false, $period->month, $valor_diferente));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                            if ($this->items_verification($period->month)) {
                              $valores_mensualizados[$period->month] = number_format($this->monto_con_inasistencias(true, $period->month, $valor_mensual));
                            }else{
                              $valores_mensualizados[$period->month] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
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

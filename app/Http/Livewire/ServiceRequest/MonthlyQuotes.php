<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\ServiceRequests\Value;
use DatePeriod;
use DateInterval;

class MonthlyQuotes extends Component
{
    public $serviceRequest;
    public $valores;
    public $resultadoEnNumero = false;
    public $string;

    public function render()
    {
        $serviceRequest = $this->serviceRequest;

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        /* TODO: Que pasa si un contrato pasa al siguiente año? */
        $year = $serviceRequest->start_date->year;

        //////////////CALCULO Y RENDERICACIÓN PARA COVID////////////////////////
        if ($serviceRequest->type == 'Covid') {

            switch ($serviceRequest->estate) {
                case 'Profesional Médico':
                case 'Farmaceutico':
                    switch ($serviceRequest->weekly_hours) {
                        case '44':
                            $estate = 'Médico 44';
                            break;
                        case '28':
                            $estate = 'Médico 28';
                            break;
                        case '22':
                            $estate = 'Médico 22';
                            break;
                        default:
                            /* TODO: No sé que hacer acá */
                            $estate = null;
                            break;
                    }
                    $valor_mensual = optional(
                        Value::orderBy('validity_from', 'desc')
                            ->where('contract_type', 'Mensual')
                            ->where('type', 'covid')
                            ->where('establishment_id', $serviceRequest->establishment_id)
                            ->where('estate', $estate)
                            ->where('work_type', $serviceRequest->working_day_type)
                            ->first()
                    )->amount;
                    //dd($valor_mensual);
                    break;
                case 'Profesional':

                    $valor_mensual = optional(
                        Value::orderBy('validity_from', 'desc')
                            ->where('contract_type', 'Mensual')
                            ->where('type', 'covid')
                            ->where('establishment_id', $serviceRequest->establishment_id)
                            ->where('estate', $serviceRequest->estate)
                            ->where('work_type', $serviceRequest->working_day_type)
                            ->first()
                    )->amount;

                    switch ($serviceRequest->weekly_hours) {
                        // case '33':
                        //     $valor_mensual = $valor_mensual * 0.75;
                        //     break;
                        //     //case '28': $valor_mensual = $valor_mensual * 0.636363; break;
                        case '22':
                            $valor_mensual = $valor_mensual * 0.5;
                            break;
                        // case '11':
                        //     $valor_mensual = $valor_mensual * 0.25;
                        //     break;
                    }
                    break;

                case 'Técnico':
                case 'Administrativo':
                case 'Odontólogo':
                case 'Bioquímico':
                case 'Auxiliar':


                    $valor_mensual = optional(
                        Value::orderBy('validity_from', 'desc')
                            ->where('contract_type', 'Mensual')
                            ->where('type', 'covid')
                            ->where('establishment_id', $serviceRequest->establishment_id)
                            ->where('estate', $serviceRequest->estate)
                            ->where('work_type', $serviceRequest->working_day_type)
                            ->first()
                    )->amount;
            }

            for ($i = $first_month; $i <= $last_month; $i++) {

                $first_day_month = 1;
                $last_day_month = Carbon::createFromDate($year, $i, 1)->lastOfMonth()->day;

                /* Si es un solo mes */
                if ($first_month == $last_month) {
                    if (
                        $serviceRequest->start_date->day == $first_day_month and
                        $serviceRequest->end_date->day == $last_day_month
                    ) {
                        /* Mes completo */
                        $valores[$i] = $valor_mensual;
                    } else {
                        $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->end_date)->days + 1;
                        /* Días trabajados */
                        $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
                    }
                }

                /* Más de un mes */ else if ($i == $first_month) {
                    /* Creo que sólo necesito el valor mensual acá, el if y else no deberían ser necesarios */
                    if ($serviceRequest->start_date->day == $first_day_month) {
                        $valores[$i] = $valor_mensual;
                    } else {
                        $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                        /* Días trabajados */
                        $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
                    }
                } else if ($i == $last_month) {
                    if ($serviceRequest->end_date->lastOfMonth()->day == $last_day_month) {
                        $valores[$i] = $valor_mensual;
                    } else {
                        $dias_trabajados = $serviceRequest->end_date->diff($serviceRequest->end_date->firstOfMonth())->days + 1;
                        /* Días trabajados */
                        $valores[$i] = round($dias_trabajados * ($valor_mensual / 30));
                    }
                } else {
                    /* Mes completo porque es el intermedio */
                    $valores[$i] = $valor_mensual;
                }
            }

            if ($this->resultadoEnNumero) {
                $this->valores = $valores;
            } else {
                $nroCuotas = count($valores);
                if ($nroCuotas == 1) {
                    $string = $nroCuotas . " cuota";
                    $string .= " de $" . number_format(current($valores)) . " el mes de " . Carbon::create()->day(1)->month(key($valores))->monthName . "; ";
                } else {
                    $string = $nroCuotas . " cuotas";

                    foreach ($valores as $key => $valor) {
                        if ($key === array_key_last($valores)) {
                            $string .= " y una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName . "; ";
                        } else {
                            $string .= ", una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName;
                        }
                    }
                }


                $this->valores = $string;
            }
        }
        ////es HONORARIO SUMA ALZADA
        else {            ///son cuotas iguales
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
                    } else if ($key === array_key_last($periods)) {
                        $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                    } else {
                        $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                    }
                }
            } else
            //son cuotas valores diferentes
            {

                if ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') and $serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 2;
                    $valor_mensual = $serviceRequest->net_amount;
                    $string = $nroCuotas . " cuotas,";
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date->addMonth());
                    $periods = iterator_to_array($periods);
                    $dias_trabajados1 = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    $valor_diferente1 = round($dias_trabajados1 * round(($valor_mensual / 30)));
                    $dias_trabajados2 = $serviceRequest->end_date->firstOfMonth()->diff($serviceRequest->end_date)->days + 1;
                    $valor_diferente2 = round($dias_trabajados2 * round(($valor_mensual / 30)));


                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            $string .= " una de $" . number_format($valor_diferente1) . " el mes de " . $period->monthName;
                        } else if ($key === array_key_last($periods)) {
                            $string .= " y una de $" . number_format($valor_diferente2) . " el mes de " . $period->monthName . ";";
                        } else {
                            $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                        }
                    }
                }



                    elseif ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d')) {
                        //La Persona no parte a trabajar en un mes cerrado
                        $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                        $valor_mensual = $serviceRequest->net_amount;
                        $string = $nroCuotas . " cuotas,";
                        $interval = DateInterval::createFromDateString('1 month');
                        $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
                        $periods = iterator_to_array($periods);
                        $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                        $valor_diferente = round($dias_trabajados * round(($valor_mensual / 30)));
                        foreach ($periods as $key => $period) {
                            if ($key === array_key_first($periods)) {
                                $string .= " una de $" . number_format($valor_diferente) . " el mes de " . $period->monthName;
                            } else if ($key === array_key_last($periods)) {
                                $string .= " y una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName . ";";
                            } else {
                                $string .= ", una de $" . number_format($valor_mensual) . " el mes de " . $period->monthName;
                            }
                        }
                    }

            }

            $this->valores = $string;
        }




        return view('livewire.service-request.monthly-quotes');
    }
}

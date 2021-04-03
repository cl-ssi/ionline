<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\ServiceRequests\Value;

class MonthlyQuotes extends Component
{
    public $serviceRequest;
    public $valores;
    public $resultadoEnNumero = false;

    public function render()
    {
        $serviceRequest = $this->serviceRequest;

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        /* TODO: Que pasa si un contrato pasa al siguiente año? */
        $year = $serviceRequest->start_date->year;

        $valor_mensual = optional(
            Value::orderBy('validity_from','desc')
            ->where('contract_type','Mensual')
            ->where('type','covid')
            ->where('estate', $serviceRequest->estate)
            ->where('work_type', $serviceRequest->working_day_type)
            ->first()
        )->amount;

        switch($serviceRequest->weekly_hours)
        {
            case '33': $valor_mensual = $valor_mensual * 0.75; break;
            case '28': $valor_mensual = $valor_mensual * 0.636363; break;
            case '22': $valor_mensual = $valor_mensual * 0.5; break;
            case '11': $valor_mensual = $valor_mensual * 0.25; break;
        }

        //echo $valor_mensual;

        for($i = $first_month; $i <= $last_month; $i ++){

            $first_day_month = 1;
            $last_day_month = Carbon::createFromDate($year, $i, 1)->lastOfMonth()->day;

            /* Si es un solo mes */
            if($first_month == $last_month) {
                if($serviceRequest->start_date->day == $first_day_month and
                   $serviceRequest->end_date->day == $last_day_month) {
                       /* Mes completo */
                       $valores[$i] = $valor_mensual;
                   }
                else {
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->end_date)->days + 1;
                    /* Días trabajados */
                    $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                }
            }

            /* Más de un mes */
            else if($i == $first_month) {
                 /* Creo que sólo necesito el valor mensual acá, el if y else no deberían ser necesarios */
                 if($serviceRequest->start_date->day == $first_day_month) {
                     $valores[$i] = $valor_mensual;
                 }
                 else {
                     $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                     /* Días trabajados */
                     $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                 }

            }
            else if($i == $last_month) {
                if($serviceRequest->end_date->lastOfMonth()->day == $last_day_month) {
                    $valores[$i] = $valor_mensual;
                }
                else {
                    $dias_trabajados = $serviceRequest->end_date->diff($serviceRequest->end_date->firstOfMonth())->days + 1;
                    /* Días trabajados */
                    $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                }
            }
            else {
                /* Mes completo porque es el intermedio */
                $valores[$i] = $valor_mensual;
            }

        }

        if ($this->resultadoEnNumero) {
            $this->valores = $valores;
        }else{
            $nroCuotas = count($valores);
            if ($nroCuotas == 1){
                $string = $nroCuotas . " cuota" ;
                $string .= " de $" . number_format(current($valores)) . " el mes de " . Carbon::create()->day(1)->month(key($valores))->monthName ."; ";
            }
            else{
                $string = $nroCuotas . " cuotas" ;

                foreach ($valores as $key => $valor) {
                    if ($key === array_key_last($valores)) {
                        $string .= " y una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName ."; ";
                    }
                    else {
                        $string .= ", una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->monthName;
                    }
                }
            }


            $this->valores = $string;
        }



        return view('livewire.service-request.monthly-quotes');
    }

}

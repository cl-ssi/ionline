<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\ServiceRequests\Value;

class MonthlyQuotes extends Component
{
    public $serviceRequest;
    public $valores;

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
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->end_date)->days;
                    /* Días trabajados */
                    $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                }
            }

            /* Más de un mes */
            if($i == $first_month) {
                if($serviceRequest->start_date->day == $first_day_month) {
                    $valores[$i] = $valor_mensual;
                }
                else {
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days;
                    /* Días trabajados */
                    $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                }

            }
            else if($i == $last_month) {
                if($serviceRequest->end_date->lastOfMonth()->day == $last_day_month) {
                    $valores[$i] = $valor_mensual;
                }
                else {
                    $dias_trabajados = $serviceRequest->end_date->diff($serviceRequest->end_date->firstOfMonth())->days;
                    /* Días trabajados */
                    $valores[$i] = round($dias_trabajados * ($valor_mensual/30));
                }
            }
            else {
                /* Mes completo porque es el intermedio */
                $valores[$i] = $valor_mensual;
            }

        }

        // setlocale(LC_ALL, 'es');
        $string = count($valores) . " cuotas" ;
        foreach ($valores as $key => $valor) {
          if($key == count($valores)){
            $string = $string . ", y una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->formatLocalized('%B') ."; ";
          }else{
            $string = $string . ", una de $" . number_format($valor) . " el mes de " . Carbon::create()->day(1)->month($key)->formatLocalized('%B');
          }
        }

        $this->valores = $string;

        return view('livewire.service-request.monthly-quotes');
    }

    public function monthName(Integer $month){
      if ($month == 1) {
        return "Enero";
      }
      if ($month == 2) {
        return "Enero";
      }
      if ($month == 3) {
        return "Enero";
      }
      if ($month == 4) {
        return "Enero";
      }
      if ($month == 5) {
        return "Enero";
      }
      if ($month == 6) {
        return "Enero";
      }
      if ($month == 7) {
        return "Enero";
      }
      if ($month == 8) {
        return "Enero";
      }
      if ($month == 9) {
        return "Enero";
      }
      if ($month == 10) {
        return "Enero";
      }
      if ($month == 11) {
        return "Enero";
      }
      if ($month == 12) {
        return "Enero";
      }
    }
}

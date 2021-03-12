<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\ServiceRequests\Value;

class MonthlyValue extends Component
{
    public $fulfillment;

    public function value($fulfillment) {
        /* Si es tipo Mensual y tipo Covid */
        if($fulfillment->serviceRequest->program_contract_type == 'Mensual' 
            AND $fulfillment->serviceRequest->type = 'Covid') {

            /* si tiene una "Renuncia voluntaria", el termino del contrato es ahí */
            if($renuncia = $fulfillment->fulfillmentItems->where('type','Renuncia voluntaria')->first()){
                $fulfillment->end_date = $renuncia->end_date;
            }

            /* si inicio de contrato coincide con inicio de mes y término de contrato coincide con fin de mes */
            if($fulfillment->start_date->toDateString() == $fulfillment->start_date->startOfMonth()->toDateString() 
                AND $fulfillment->end_date->toDateString() == $fulfillment->end_date->endOfMonth()->toDateString() ) {

                $total_dias_trabajados = 30;
                $mes_completo = true;
            }
            /* De lo contrario es la diferencia entre el primer y último día */
            else {
                $total_dias_trabajados = $fulfillment->start_date->diff($fulfillment->end_date)->days + 1;
                $mes_completo = false;
            }

            /* Restar las ausencias */
            $dias_descuento = 0;

            foreach($fulfillment->fulfillmentItems as $item) 
            {
                switch($item->type) 
                {
                    case 'Inasistencia Injustificada':
                    case 'Licencia no covid':
                    case 'Abandono de funciones':
                        $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                        break;
                }
                
            }

            $total_dias_trabajados -= $dias_descuento;

            /* Obtener de sr_values el valor mensual */
            switch($fulfillment->serviceRequest->estate) 
            {
                case 'Profesional Médico':
                    switch($fulfillment->serviceRequest->weekly_hours)
                    {
                        case '44': $estate = 'Médico 44'; break;
                        case '28': $estate = 'Médico 28'; break;
                        case '22': $estate = 'Médico 22'; break;
                        default:
                            /* TODO: No sé que hacer acá */
                            $estate = null;
                            break;
                    }
                    /* Calcular total de la boleta */
                    $valor_mensual = optional(
                        Value::orderBy('validity_from','desc')
                        ->where('contract_type','Mensual')
                        ->where('type','covid')
                        ->where('state', $estate)
                        ->where('work_type', $fulfillment->serviceRequest->working_day_type)
                        ->first()
                    )->amount;
                    break;
                case 'Profesional':
                case 'Técnico':
                case 'Administrativo':
                case 'Farmaceutico':
                case 'Odontólogo':
                case 'Bioquímico':
                case 'Auxiliar':
                    /* Calcular total de la boleta */
                    $valor_mensual = optional(
                        Value::orderBy('validity_from','desc')
                        ->where('contract_type','Mensual')
                        ->where('type','covid')
                        ->where('estate', $fulfillment->serviceRequest->estate)
                        ->where('work_type', $fulfillment->serviceRequest->working_day_type)
                        ->first()
                    )->amount;
                    break;
                case 'Otro (justificar)':
                    /* TODO: No se que se hace acá */
                    $valor_mensual = 0;
                    break;
                default:
                    /* TODO: No se que se hace acá */
                    $valor_mensual = 0;
                    break;

            }

            if($mes_completo) {
                $total = $valor_mensual - ($dias_descuento * ($valor_mensual / 30) ) ; 
            }
            else {
                $total = $total_dias_trabajados * ($valor_mensual / 30);
            }

        }

        return number_format(round($total), 0, ',', '.');
        

        /*
         

        if(Tipo de Contratación = Mensual AND Tipo == Honorario COVID)
            switch(Estamento)
                case (Profesional)
                    switch(Jornada de Trabajo)
                        case(Diurno)
                            $total = $total_días_trabajados * valor diario profesional diurno
                        case(4° Turno)
                            $total = $total_días_trabajados * valor diario profesional 4° turno
                        case(3° Turno)
                            $total = $total_días_trabajados * valor diario profesional 3° turno

                case (Tecnico)
                    switch(Jornada de Trabajo)
                        case(Diurno)
                            $total = $total_días_trabajados * valor diario técnico diurno
                        case(4° Turno)
                            $total = $total_días_trabajados * valor diario técnico 4° turno
                        case(3° Turno)
                            $total = $total_días_trabajados * valor diario técnico 3° turno

                case (Administrativo)
                    switch(Jornada de Trabajo)
                        case(Diurno)
                            $total = $total_días_trabajados * valor diario administrativo diurno
                        case(4° Turno)
                            $total = $total_días_trabajados * valor diario administrativo 4° turno
                        case(3° Turno)
                            $total = $total_días_trabajados * valor diario administrativo 3° turno

                case (Auxiliar)
                    switch(Jornada de Trabajo)
                        case(Diurno)
                            $total = $total_días_trabajados * valor diario auxiliar diurno
                        case(4° Turno)
                            $total = $total_días_trabajados * valor diario auxiliar 4° turno
                        case(3° Turno)
                            $total = $total_días_trabajados * valor diario auxiliar 3° turno

                case (Médico)
                    switch(Horas Semanales)
                        case (44)
                            $total = $total_días_trabajados * valor diario médico 44
                        case (28)
                            $total = $total_días_trabajados * valor diario médico 28
                        case (22)
                            $total = $total_días_trabajados * valor diario médico 22
                        default
                            No se que se hace para las 33 y para 11 horas

        return $total;
        */
    }

    public function render()
    {
        $invoice_value = $this->value($this->fulfillment);
        return view('livewire.service-request.monthly-value', ['invoice' => $invoice_value]);
    }
}

<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
use App\Helpers\DateHelper;
use App\Models\Parameters\Holiday;
use App\Models\Rrhh\AmiLoad;

class ReportByDates extends Component
{

    public $finicio;
    public $ftermino;
    public $userWithContracts;
    // public $absenteeisms = [];
    // public $array = [];
    public $shiftAmmount;

    protected $rules = [
        'finicio' => 'required',
        'ftermino' => 'required',
    ];

    // public function mount(){
    //     $this->finicio = Carbon::createFromDate('2023-06-01');
    //     $this->ftermino = Carbon::createFromDate('2023-06-30');
    // }

    // public function trClick($row){
    //     $this->search();
    //     $this->array[$row] = true;
    // }

    // public function mount(){
    //     $this->shiftAmmount = 5840;
    // }

    public function search(){

        $this->validate();

        /* Valor de amipass */
        $dailyAmmount = 4480;
        $this->shiftAmmount = 5840;

        // format fechas
        if($this->finicio && $this->ftermino){
            $startDate = Carbon::createFromDate($this->finicio);
            $endDate = Carbon::createFromDate($this->ftermino);
        }

        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        /* Obtener los usuarios que tienen contratos en un rango de fecha con sus ausentismos */
        $this->userWithContracts = User::with([
                'contracts' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                                ->whereDate('fecha_termino_contrato', '>=', $startDate)
                                ->where('shift',0);
                    });
                },
                'absenteeisms' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('finicio', '<=', $endDate)
                            ->whereDate('ftermino', '>=', $startDate);
                        });
                },
                'amiLoads' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereMonth('fecha',$startDate->month);
                        });
                },
                'shifts' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->where('year',$startDate->year)
                                ->where('month',$startDate->month);
                        });
                },
                'absenteeisms.type.discountCondition'
            ])
            ->whereHas('contracts', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                        ->whereDate('fecha_termino_contrato', '>=', $startDate);
                        // ->where('shift',0); se traen todos, abajo se hace el filtro
                });
            })
            // ->where('id',9994426)
            ->get();        

        foreach($this->userWithContracts as $row => $user) {
            // si tiene turnos
            if($user->shifts->count()>0)
            {
                foreach($user->shifts as $shift){
                    $shift->ammount = $shift->quantity * $this->shiftAmmount;
                }
            }
            else
            {
                // $this->array[$row] = "none";
                /**
                 * TODO: ausentismos
                 * Que hacer con los medios días, 0.5, 1.5, etc en total_dias_ausentismo
                 *
                 * Cosas que analizar:
                 * - Cargar personas con turno (Estefania tiene un listado de las personas con truno)
                 * - Hay permisos adminsitrativos los sabados o domingos (para los que tienen turno si afecta)
                 * - Hay LM que se solapan los días (no duplicar descuento), que hacer si un ausentismo se solapa con otro
                 * - Incorporar calculo con valores 4.800 y 5.800 para los con turno
                 * - Almacenar el archivo de carga de amipass, para mostrar columna "Cargado en AMIPASS" wel_ami_recargas (ingles)
                 * - Que hacer con la fecha de alejamiento?  01-01-2023 -> 31-12-2023 fecha alejamiento (05-06-023)
                 * - Contratos que se suman, por ejemplo. dos contrtos de 22 horas, suman 44, cuando en el mismo instante del tiempo, tenga 44
                 *   ej: 14105981
                 *   11 horas           1....................30
                 *   22 horas                     15.........30
                 *   contrato_calculo             15.........30
                 *   ausentismo              x          x
                 *                                   AMIPASS
                 *  Tiene mas de un contrato? funcion calcular inico y termino de contrato
                 *
                 *  Archivo de salida
                 *  run       |   monto
                 *  14105981  |   108.000
                 *
                 * tipo_de_ausentismo
                 * L.M. ENFERMEDAD  si se descuenta
                 * COMISION DE SERVICIO sobre 1
                 * FERIADOS LEGALES si se descuenta
                 * PERMISOS ADMINISTRATIVOS desde 0,5
                 * DIAS COMPENSATORIOS sobre 1
                 * SUSP. EMP. MED. DISCIPLINARIA descuento
                 * TELETRABAJO FUNCIONES NO HABITUALES no se descuenta
                 * PERMISO DESCANSO REPARATORIO si se descuenta
                 * TELETRABAJO FUNCIONES HABITUALES no se descuenta
                 * L.M. ACCIDENTE EN LUGAR DE TRABAJO si se descuenta
                 * L.M. ACCIDENTE EN TRAYECTORIA AL TRABAJO si se descuenta
                 * PERMISOS S/SUELDOS si se descuenta
                 * L.M. ENFERMEDAD PROFESIONAL  si se descuenta
                 * L.M. MATERNAL  si se descuenta
                 * L.M. PATOLOGIA DEL EMBARAZO  si se descuenta
                 * POSTNATAL PARENTAL si se descuenta
                 * L.M. PRORROGA DE MEDICINA PREVENTIVA  si se descuenta
                 * PERMISO GREMIAL no se descuenta
                 * L.M. ENFERMEDAD GRAVE HIJO MENOR DE UN AÑO  si se descuenta
                 * FALLECIMIENTO HERMANO/A si se descuenta
                 * 
                 * No incluir funcionarios con contrato y que sean turno (shift = 1)
                 */
                $user->totalAbsenteeisms = 0;

                $lastdate=null;

                // ->where('finicio','>=',$startDate)->where('ftermino','<=',$endDate)
                foreach($user->absenteeisms->sortBy('finicio') as $key => $absenteeism) {
                    
                    // si el tipo de ausentismo no considera descuento, se sigue en la siguiente iteración
                    if(!$absenteeism->type->discount){
                        $absenteeism->totalDays = 0;
                        continue;
                    }

                    // si se debe hacer descuento, se verifica si existe algúna condición
                    if($absenteeism->type->discountCondition){
                        if($absenteeism->total_dias_ausentismo >= $absenteeism->type->discountCondition->from){

                        }else{
                            $absenteeism->totalDays = 0;
                            continue;
                        }
                    }

                    $absenteeismStartDate = $absenteeism->finicio->isBefore($startDate) ? $startDate : $absenteeism->finicio;
                    $absenteeismEndDate = $absenteeism->ftermino->isAfter($endDate) ? $endDate : $absenteeism->ftermino;

                    // solapamiento de contratos.
                    // si fecha de contrato anterior es mayor a la de inicio actual, se comienza desde el dia siguiente de fecha anterior.
                    if($lastdate>=$absenteeismStartDate){
                        $absenteeismStartDate = $lastdate->addDays(1);
                    }
                    $lastdate= $absenteeismEndDate;

                    $absenteeism->totalDays = DateHelper::getBusinessDaysByDateRangeHolidays($absenteeismStartDate, $absenteeismEndDate, $holidays)->count();
                    $user->totalAbsenteeisms += $absenteeism->totalDays;

                    // $this->absenteeisms[$user->id] = $absenteeism;
                }

                $user->totalAbsenteeismsEnBd = $user->absenteeisms->sum('total_dias_ausentismo');

                foreach($user->contracts as $contract) {
                    /** Días laborales */
                    $contract->businessDays =
                        DateHelper::getBusinessDaysByDateRangeHolidays(
                                $contract->fecha_inicio_contrato->isAfter($startDate) ? $contract->fecha_inicio_contrato : $startDate,
                                $contract->fecha_termino_contrato->isBefore($endDate) ? $contract->fecha_termino_contrato : $endDate,
                                $holidays
                            )->count();

                    /** Calcular monto de amipass a transferir */
                    $contract->ammount = $dailyAmmount * ($contract->businessDays - $user->totalAbsenteeisms);

                    /**
                     * Todo: Pendiente resolver los contratos de 11, 22, 33 horas, ya que esas personas salen repetidas en el reporte
                     */
                }

            }

            // obtiene monto pagado y cargado en tabla ami_loads
            foreach($user->amiLoads as $amiLoad) {
                $user->AmiLoadMount += $amiLoad->monto;
            }

            // obtiene diferencia
            if($user->shifts->count() > 0){$user->diff = $user->shifts->sum('ammount') - $user->AmiLoadMount;}
            else{$user->diff = $user->contracts->sum('ammount') - $user->AmiLoadMount;}
        }
    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-dates')->extends('layouts.bt4.app');
    }
}

<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

use App\Models\Parameters\Holiday;
use App\Models\Rrhh\AmiLoad;
use App\Models\Welfare\Amipass\Charge;
use App\Models\Rrhh\CompensatoryDay;
use App\Models\Rrhh\AbsenteeismType;

class ReportByDates extends Component
{

    public $finicio;
    public $ftermino;
    public $userWithContracts;
    public $dailyAmmount;
    public $shiftAmmount;
    public $output = [];

    protected $rules = [
        'finicio' => 'required',
        'ftermino' => 'required',
    ];

    public function mount(){
        $this->finicio = Carbon::createFromDate('2023-03-01');
        $this->ftermino = Carbon::createFromDate('2023-03-31');
    }

    public function search(){

        $this->validate();

        /* Valor de amipass */
        $this->dailyAmmount = 4480;
        $this->shiftAmmount = 5840;

        // format fechas
        if($this->finicio && $this->ftermino){
            $startDate = Carbon::createFromDate($this->finicio);
            $endDate = Carbon::createFromDate($this->ftermino);
        }

        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();
        $compensatoryAbsenteeismType = AbsenteeismType::find(5);
        
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
                            ->whereDate('ftermino', '>=', $startDate)
                            ->where('absenteeism_type_id','!=',5);
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
                'compensatoryDays' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('start_date', '<=', $endDate)
                            ->whereDate('end_date', '>=', $startDate);
                        });
                },
                'absenteeisms.type'
            ])
            ->whereHas('contracts', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                        ->whereDate('fecha_termino_contrato', '>=', $startDate);
                        // ->where('shift',0); se traen todos, abajo se hace el filtro
                });
            })
            // ->whereIn('id',[9949268])
            ->get();   




        foreach($this->userWithContracts as $row => $user) {

            // si tiene turnos
            if($user->shifts->count()>0)
            {
                foreach($user->shifts as $shift){
                    $shift->ammount = $shift->quantity * $this->shiftAmmount;
                    
                    // se genera array para exportación de montos
                    if(!array_key_exists($user->id,$this->output)){$this->output[$user->id] = 0;}
                    $this->output[$user->id] += $shift->ammount;
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
                 *   Sobre 33 hrs se considera para calculo amipass. 
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
                
                $numero_horas = 0;
                $businessDays = 0;

                


                // Obtiene array de días según contratos (ejemplo Contrato del 1 al 30, Contrato del 15 al 30, Result del 15 al 30)
                // Intersectar horas de posibles contratos
                $dateResult = array();
                $contractDates = array();
                foreach($user->contracts as $key => $contract) {
                    // obtiene la suma de horas estupiladas en los contratos (para analisis más abajo)
                    $numero_horas += $contract->numero_horas;

                    // Se crea array con fechas del periodo de cada contrato
                    $period = CarbonPeriod::create($contract->fecha_inicio_contrato->isAfter($startDate) ? $contract->fecha_inicio_contrato : $startDate, 
                                                   $contract->fecha_termino_contrato->isBefore($endDate) ? $contract->fecha_termino_contrato : $endDate);
                    $dateResult[$key] = $period->toArray();
                    
                    // se dejan solo fechas que se intercepten
                    if($key > 0){
                        $contractDates = array_intersect($dateResult[$key-1], $period->toArray());
                    }else{
                        $contractDates = $period->toArray();
                    }

                }

                // se obtiene primera y ultima fecha (keys del array) del cruce (para analisis posterior)
                $first_key = array_key_first($contractDates);
                $last_key = array_key_last($contractDates);
                
                // días laborales reales (considerando cruze de contratos)
                $businessDays = DateHelper::getBusinessDaysByDateRangeHolidays($contractDates[$first_key],$contractDates[$last_key],$holidays, $user->id)->toArray();
                //cantidad de días laborales
                $businessDays = count($businessDays);
                $user->businessDays = $businessDays;
                




                // variable para mostrar horas en vista
                $user->contract_hours = $numero_horas;
                
                // si es menor o igual a 33, no se sigue con el analisis para este usuario
                if($numero_horas <= 33){
                    continue;
                }



                

                foreach($user->absenteeisms->sortBy('finicio') as $key => $absenteeism) {
                    // si el tipo de ausentismo no considera descuento, se sigue en la siguiente iteración
                    if(!$absenteeism->type->discount){
                        $absenteeism->totalDays = 0;
                        continue;
                    }

                    // condición desde un valor
                    if($absenteeism->type->from){
                        if($absenteeism->total_dias_ausentismo >= $absenteeism->type->from){

                        }else{
                            $absenteeism->totalDays = 0;
                            continue;
                        }
                    }
                    // condición sobre un valor
                    if($absenteeism->type->over){
                        if($absenteeism->total_dias_ausentismo > $absenteeism->type->over){

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
                    $lastdate = $absenteeismEndDate->copy();

                    $absenteeism->totalDays = DateHelper::getBusinessDaysByDateRangeHolidays($absenteeismStartDate, $absenteeismEndDate, $holidays, $user->id)->count();
                    $user->totalAbsenteeisms += $absenteeism->totalDays;

                    // $this->absenteeisms[$user->id] = $absenteeism;
                    
                }

                $user->totalAbsenteeismsEnBd = $user->absenteeisms->sum('total_dias_ausentismo');

                

                


                // dd($user->compensatoryDays);
                // dias compensatorios
                foreach($user->compensatoryDays as $key => $compensatoryDay){
                    // genera array con inicio y termino de cada periodo del rango
                    $start = $compensatoryDay->start_date;
                    $end = $compensatoryDay->end_date;
                    
                    $dates = [];
                    $datesArray = iterator_to_array(new \DatePeriod($start, new \DateInterval('P1D'), $end));
                    array_walk($datesArray, function ($value, $key) use (&$dates, $start, $end) {
                        $dates[$key]['start'] = (
                            ($key == 0) ? $value->format('Y-m-d H:i:s') : $value->setTime(00, 0, 00)->format('Y-m-d H:i:s')
                        );
                        $endDate = $value->setTime(23, 59, 59);
                        if ($endDate->getTimestamp() > $end->getTimestamp()) {
                            $endDate = $end;
                        }
                        $dates[$key]['end'] = $endDate->format('Y-m-d H:i:s');
                    });
                    
                    // verifica si el día compensatorio por día es mayor a 8
                    $cant_dias = 0;
                    $cant_dias_dias_compensatorios = 0;
                    foreach($dates as $key => $date){
                        $start = Carbon::parse($date['start']);
                        $end = Carbon::parse($date['end']);

                        if($compensatoryAbsenteeismType->over!=null){
                            // sobre
                            if($start->diffInHours($end) > $compensatoryAbsenteeismType->over){
                                $cant_dias += 1;
                                // si es que está dentro del rango
                                if($start->between($this->finicio, $this->ftermino)){
                                    $cant_dias_dias_compensatorios += 1;
                                }
                            }
                        }elseif($compensatoryAbsenteeismType->from!=null){
                            // desde
                            if($start->diffInHours($end) >= $compensatoryAbsenteeismType->over){
                                $cant_dias += 1;
                                // si es que está dentro del rango
                                if($start->between($this->finicio, $this->ftermino)){
                                    $cant_dias_dias_compensatorios += 1;
                                }
                            }
                        }
                        
                    }

                    $compensatoryDay->total_dias_ausentismo = $cant_dias;
                    $compensatoryDay->totalDays = $cant_dias_dias_compensatorios; 
                }

                // Se suma el valor a la cantidad de ausentismos (para suma calculo de cantidad total sumando ausentismos)
                // dd($user->compensatoryDays);
                if(count($user->compensatoryDays)>0){
                    $user->totalAbsenteeismsEnBd += $user->compensatoryDays->sum('total_dias_ausentismo');
                    $user->totalAbsenteeisms += $user->compensatoryDays->sum('totalDays');
                }
                






                // obtiene monto a pagar de la ausencia y la asigna a usuario
                $user->ammount = $this->dailyAmmount * ( $businessDays - $user->totalAbsenteeisms);
                
                // se genera array para exportación de montos
                if(!array_key_exists($user->id,$this->output)){$this->output[$user->id] = 0;}
                $this->output[$user->id] += $user->ammount;



                // if($user->id == 15685556){
                //     dd($dailyAmmount,$businessDays,$user->totalAbsenteeisms);
                // }

                // 
                // foreach($user->contracts as $contract) {
                //     /** Días laborales */
                //     $contract->businessDays =
                //         DateHelper::getBusinessDaysByDateRangeHolidays(
                //                 $contract->fecha_inicio_contrato->isAfter($startDate) ? $contract->fecha_inicio_contrato : $startDate,
                //                 $contract->fecha_termino_contrato->isBefore($endDate) ? $contract->fecha_termino_contrato : $endDate,
                //                 $holidays, $user->id
                //             )->count();

                //     /** Calcular monto de amipass a transferir */
                //     $contract->ammount = $dailyAmmount * ($contract->businessDays - $user->totalAbsenteeisms);

                //     // se genera array para exportación de montos
                //     if(!array_key_exists($user->id,$this->output)){$this->output[$user->id] = 0;}
                //     $this->output[$user->id] += $contract->ammount;

                //     /**
                //      * Todo: Pendiente resolver los contratos de 11, 22, 33 horas, ya que esas personas salen repetidas en el reporte
                //      */
                // }

            }

            // obtiene monto pagado y cargado en tabla ami_loads
            foreach($user->amiLoads as $amiLoad) {
                $user->AmiLoadMount += $amiLoad->monto;
            }

            // obtiene diferencia
            if($user->shifts->count() > 0){$user->diff = $user->shifts->sum('ammount') - $user->AmiLoadMount;}
            else{$user->diff = $user->contracts->sum('ammount') - $user->AmiLoadMount;}




            // se agrega para realizar comparación con información de tabla 'Charges' (se debe eiminar dsps)
            $charges = Charge::where('rut', $user->id)->get();
            $meses[] = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
            foreach($charges as $key => $charge){
                list($day, $month, $year) = explode('-', $charge->fecha);
                $date_string = '2023-' . $day . "-" . str_pad((array_search($month, $meses)+1), 2, "0", STR_PAD_LEFT);
                $charge->date = Carbon::parse($date_string);

                if($charge->date >= $startDate && $charge->date <= $endDate){
                    $user->dias_ausentismo = $charge->dias_ausentismo;
                    $user->valor_debia_cargarse = $charge->valor_debia_cargarse;
                    break;
                }
            }
        }
    }

    public function export()
    {   
        return response()->streamDownload(function () {
            foreach($this->output as $key => $row){
                echo $key.";".$row.";\r\n";
            }
        }, 'export.txt');

    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-dates')->extends('layouts.bt4.app');
    }
}

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
    // public $array = [];

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

    public function search(){

        $this->validate();

        /* Valor de amipass */
        $dailyAmmount = 4480;
        $shiftAmmount = 5840;

        /* Definir las fechas de inicio y término */
        // $startDate = Carbon::createFromDate('2023-06-01');
        // $endDate = Carbon::createFromDate('2023-06-30');

        if($this->finicio && $this->ftermino){
            $startDate = Carbon::createFromDate($this->finicio);
            $endDate = Carbon::createFromDate($this->ftermino);
        }

        // dd($startDate, $endDate);

        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        /* Obtener los usuarios que tienen contratos en un rango de fecha con sus ausentismos */
        $this->userWithContracts = User::with([
                'contracts' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                            ->whereDate('fecha_termino_contrato', '>=', $startDate);
                    });
                },
                'absenteeisms' => function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereDate('finicio', '<=', $endDate)
                            ->whereDate('ftermino', '>=', $startDate);
                        });
                }
            ])
            ->with('absenteeisms.type','amiLoads')
            ->whereHas('contracts', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                        ->whereDate('fecha_termino_contrato', '>=', $startDate);
                });
            })
            // // solo se consideran usuarios que tengan ausentismos con descuentos
            // ->whereHas('absenteeisms', function ($query) {
            //     $query->whereHas('type', function ($query) {
            //                 $query->where('discount', 1);
            //             });
            // })
            // ->where('id',6811637)
            ->get();

        // obtiene cargas del mes y usuarios buscados
        $amiLoads = AmiLoad::whereMonth('fecha',$startDate->month)
                            ->whereIn('run',$this->userWithContracts->pluck('id')->toArray())
                            ->get();

        foreach($this->userWithContracts as $row => $user) {

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
             */
            $user->totalAbsenteeisms = 0;

            $lastdate=null;
            foreach($user->absenteeisms->sortBy('finicio') as $key => $absenteeism) {
                // dd($absenteeism);

                // si el tipo de ausentismo no considera descuento, se sigue en la siguiente iteración
                if(!$absenteeism->type->discount){
                    $absenteeism->totalDays = 0;
                    continue;
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

        // obtiene monto pagado y cargado en tabla ami_loads
        $mes = $startDate->month;
        $user->AmiLoadMount = $amiLoads->where('run',$user->id)->sum('monto');
        $user->amiLoads = $amiLoads->where('run',$user->id);
        // $user->AmiLoadMount = AmiLoad::where('run',$user->id)
        //                             ->whereMonth('fecha',$startDate->month)
        //                             ->sum('monto');

        // obtiene diferencia
        $user->diff = $user->contracts->sum('ammount') - $user->AmiLoadMount;
        }
        // dd($user);
    }

    public function render()
    {
        return view('livewire.welfare.amipass.report-by-dates')->extends('layouts.bt4.app');
    }
}

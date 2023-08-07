<?php

namespace App\Http\Livewire\Welfare\Amipass;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
use App\Helpers\DateHelper;

class ReportByDates extends Component
{
    public function render()
    {
        /* Valor de amipass */
        $dailyAmmount = 4800;

        /* Definir las fechas de inicio y término */
        $startDate = Carbon::createFromDate('2023-06-01');
        $endDate = Carbon::createFromDate('2023-06-30');


        /* Obtener los usuarios que tienen contratos en un rango de fecha con sus ausentismos */
        $userWithContracts = User::with([
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
            ->whereHas('contracts', function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereDate('fecha_inicio_contrato', '<=', $endDate)
                        ->whereDate('fecha_termino_contrato', '>=', $startDate);
                });
            })
            ->get();

        foreach($userWithContracts as $user) {
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
             */
            $user->totalAbsenteeisms = 0;

            foreach($user->absenteeisms as $absenteeism) {
                $absenteeismStartDate = $absenteeism->finicio->isBefore($startDate) ? $startDate : $absenteeism->finicio;
                $absenteeismEndDate = $absenteeism->ftermino->isAfter($endDate) ? $endDate : $absenteeism->ftermino;

                $absenteeism->totalDays = DateHelper::getBusinessDaysByDateRange($absenteeismStartDate, $absenteeismEndDate)->count();
                $user->totalAbsenteeisms += $absenteeism->totalDays;
            }

            $user->totalAbsenteeismsEnBd = $user->absenteeisms->sum('total_dias_ausentismo');

            foreach($user->contracts as $contract) {
                /** Días laborales */
                $contract->businessDays = 
                    DateHelper::getBusinessDaysByDateRange(
                            $contract->fecha_inicio_contrato->isAfter($startDate) ? $contract->fecha_inicio_contrato : $startDate, 
                            $contract->fecha_termino_contrato->isBefore($endDate) ? $contract->fecha_termino_contrato : $endDate
                        )->count();

                /** Calcular monto de amipass a transferir */
                $contract->ammount = $dailyAmmount * ($contract->businessDays - $user->totalAbsenteeisms);

                /**
                 * Todo: Pendiente resolver los contratos de 11, 22, 33 horas, ya que esas personas salen repetidas en el reporte
                 */
            }
        }

        return view('livewire.welfare.amipass.report-by-dates', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'userWithContracts' => $userWithContracts
        ]);
    }
}

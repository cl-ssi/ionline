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
        $userWithContracts = User::with(['contracts','absenteeisms' => function ($query) use ($startDate, $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereDate('finicio', '<=', $endDate)
                    ->whereDate('ftermino', '>=', $startDate);
                });
            }])
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
             * El ausentismo puede ser de más días que el rango de búsqueda
             * por lo tanto hay que solo conciderar los días que están dentro del rango de fechas
             * y sumarlos
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
            }
        }

        return view('livewire.welfare.amipass.report-by-dates', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'userWithContracts' => $userWithContracts
        ]);
    }
}

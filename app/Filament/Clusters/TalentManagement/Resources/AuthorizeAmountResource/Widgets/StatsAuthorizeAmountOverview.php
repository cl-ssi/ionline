<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\IdentifyNeeds\AnnualBudget;
use App\Models\IdentifyNeeds\AuthorizeAmount;

class StatsAuthorizeAmountOverview extends BaseWidget
{
    protected function getStats(): array
    {   
        // PRESUPUESTO ANUAL LEY 18.834 RED ASISTENCIAL
        $budget18834Ra = AnnualBudget::query()
            ->where('law', '18834')
            ->where('item', 'red asistencial')
            ->value('budget');
        $budget18834RaAccepted = AuthorizeAmount::whereHas('identifyNeed', function ($query) {
                $query->where('law', '18834')
                    ->where('nature_of_the_need', 'red asistencial');
            })
            ->where('status', 'accepted')
            ->sum('authorize_amount');
        
        // PRESUPUESTO ANUAL LEY 18.834 DSS
        $budget18834Dss = AnnualBudget::query()
            ->where('law', '18834')
            ->where('item', 'dss')
            ->value('budget');
        $budget18834DssAccepted = AuthorizeAmount::whereHas('identifyNeed', function ($query) {
                $query->where('law', '18834')
                    ->where('nature_of_the_need', 'dss');
            })
            ->where('status', 'accepted')
            ->sum('authorize_amount');
        
        // PRESUPUESTO ANUAL LEY 19.664 RED ASISTENCIAL
        $budget19664Ra = AnnualBudget::query()
            ->where('law', '19664')
            ->where('item', 'red asistencial')
            ->value('budget');
        $budget196644RaAccepted = AuthorizeAmount::whereHas('identifyNeed', function ($query) {
                $query->where('law', '19664')
                    ->where('nature_of_the_need', 'red asistencial');
            })
            ->where('status', 'accepted')
            ->sum('authorize_amount');
        
        // PRESUPUESTO ANUAL LEY 19.664 DSS
        $budget19664Dss = AnnualBudget::query()
            ->where('law', '19664')
            ->where('item', 'dss')
            ->value('budget');
        $budget19664DssAccepted = AuthorizeAmount::whereHas('identifyNeed', function ($query) {
                $query->where('law', '19664')
                    ->where('nature_of_the_need', 'dss');
            })
            ->where('status', 'accepted')
            ->sum('authorize_amount');

        return [
            Stat::make('Ley N° 18.834 - Red Asistencial '.now()->year, '$'. number_format(
                $budget18834RaAccepted, 0, ',', '.'). ' CLP'
            )
            ->description('De $' .number_format($budget18834Ra, 0, ',','.')),
            Stat::make('Ley N° 18.834 - D. Servicio de Salud '.now()->year, '$'. number_format(
                $budget18834DssAccepted, 0, ',', '.'). ' CLP'
            )
            ->description('De $' .number_format($budget18834Dss, 0, ',','.')),
            Stat::make('Ley N° 19.664 - Red Asistencial '.now()->year, '$'. number_format(
                $budget196644RaAccepted, 0, ',', '.'). ' CLP'
            )
            ->description('De $' .number_format($budget19664Ra, 0, ',','.')),
            Stat::make('Ley N° 19.664 - D. Servicio de Salud '.now()->year, '$'. number_format(
                $budget19664DssAccepted, 0, ',', '.'). ' CLP'
            )
            ->description('De $' .number_format($budget19664Dss, 0, ',','.')),
        ];
        
    }

    protected function getColumns(): int
    {
        return 4; // Cambia a 1, 2 o 3 según el tamaño deseado
    }
}

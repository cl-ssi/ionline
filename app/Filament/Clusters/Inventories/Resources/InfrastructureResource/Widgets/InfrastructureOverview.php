<?php

namespace App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Inventories\Eqm\Infrastructure;

class InfrastructureOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalInfrastructure = Infrastructure::count();
        $totalMaintenanceCost = Infrastructure::sum('annual_maintenance_cost');
        $averageMaintenanceFrequency = Infrastructure::average('annual_maintenance_frequency');

        return [
            Stat::make('Total de Elementos de Infraestructura', $totalInfrastructure),
            Stat::make('Costo Total Anual de Mantenimiento', number_format($totalMaintenanceCost, 0, ',', '.') . ' CLP'),
            Stat::make('Frecuencia Anual Promedio de Mantenimiento', round($averageMaintenanceFrequency, 2)),
        ];
    }
}

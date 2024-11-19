<?php

namespace App\Filament\Clusters\Inventories\Resources\VehicleResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Inventories\Eqm\Vehicle;

class VehicleOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalVehicles = Vehicle::count();
        $totalMaintenanceCost = Vehicle::sum('annual_maintenance_cost');
        $averageMaintenanceFrequency = Vehicle::average('annual_maintenance_frequency');

        return [
            Stat::make('Total de Vehículos', $totalVehicles),
            Stat::make('Costo Total Anual de Mantenimiento', number_format($totalMaintenanceCost, 0, ',', '.') . ' CLP'),
            Stat::make('Frecuencia Anual Promedio de Mantenimiento', round($averageMaintenanceFrequency, 2)),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Inventories\Eqm\Equipment;

class IndustrialEquipmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $industrialEquipmentCount = Equipment::where('type', 'Industrial')->count();
        $averageCost = Equipment::where('type', 'Industrial')->average('annual_cost');

        return [
            Stat::make('Total de Equipos Industriales', $industrialEquipmentCount),
            Stat::make('Costo Anual Promedio', number_format($averageCost, 2) . ' CLP'),
        ];
    }
}

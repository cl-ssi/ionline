<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Inventories\Eqm\Equipment;

class EquipmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEquipment = Equipment::count();
        $industrialCount = Equipment::where('type', 'Industrial')->count();
        $medicalCount = Equipment::where('type', 'Médico')->count();

        return [
            Stat::make('Total de Equipos', $totalEquipment),
            Stat::make('Equipos Industriales', $industrialCount),
            Stat::make('Equipos Médicos', $medicalCount),
        ];
    }
}

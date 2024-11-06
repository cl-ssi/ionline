<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Inventories\Eqm\Equipment;

class MedicalEquipmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $medicalEquipmentCount = Equipment::where('type', 'Médico')->count();
        $averageCost = Equipment::where('type', 'Médico')->average('annual_cost');

        return [
            Stat::make('Total de Equipos Médicos', $medicalEquipmentCount),
            Stat::make('Costo Anual Promedio', number_format($averageCost, 2) . ' CLP'),
        ];
    }
}

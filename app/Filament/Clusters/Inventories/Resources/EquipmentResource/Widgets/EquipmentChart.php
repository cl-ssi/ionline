<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Inventories\Eqm\Equipment;

class EquipmentChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Equipamiento';

    protected function getData(): array
    {
        $industrialCount = Equipment::where('type', 'Industrial')->count();
        $medicalCount = Equipment::where('type', 'Médico')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Equipamiento',
                    'data' => [$industrialCount, $medicalCount],
                    'backgroundColor' => ['#36A2EB', '#FF6384'],
                ],
            ],
            'labels' => ['Industrial', 'Médico'],
        ];
    }
    
    protected function getType(): string
    {
        return 'pie';
    }
}

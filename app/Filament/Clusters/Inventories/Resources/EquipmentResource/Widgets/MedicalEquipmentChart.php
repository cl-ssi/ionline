<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Inventories\Eqm\Equipment;

class MedicalEquipmentChart extends ChartWidget
{
    protected static ?string $heading = 'Ejecución Anual - Equipos Médicos';

    protected function getData(): array
    {
        // Obtener la cantidad de equipos médicos
        $medicalEquipmentCount = Equipment::where('type', 'Médico')->count();

        // Si hay información en el modelo, generar un porcentaje aleatorio de avance
        if ($medicalEquipmentCount > 0) {
            $executionPercentage = rand(0, 100);  // Genera un porcentaje aleatorio entre 0 y 100
        } else {
            $executionPercentage = 0;  // Si no hay datos, el avance es 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ejecutado',
                    'data' => [$executionPercentage],
                    'backgroundColor' => '#FF6384',
                ],
                [
                    'label' => 'No Ejecutado',
                    'data' => [100 - $executionPercentage],
                    'backgroundColor' => '#FFCE56',
                ],
            ],
            'labels' => ['Progreso'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}

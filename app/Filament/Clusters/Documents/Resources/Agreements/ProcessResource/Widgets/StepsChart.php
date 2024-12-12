<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

class StepsChart extends ChartWidget
{
    protected static ?string $heading = 'Avance del proceso';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '100px';

    public ?Model $record = null;

    //position
    public int $x = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Confección',
                    'data' => [8],
                    'backgroundColor' => 'rgba(54, 162, 235)',
                ],
                [
                    'label' => 'Visaciones',
                    'data' => [8],
                    'backgroundColor' => 'rgba(54, 162, 235)',
                ],
                [
                    'label' => 'Envío a comuna',
                    'data' => [8],
                    'backgroundColor' => 'rgba(54, 162, 235)',
                ],
                [
                    'label' => 'Devuelto de comuna',
                    'data' => [8],
                    'backgroundColor' => 'rgba(54, 162, 235)',
                ],
                [
                    'label' => 'Firmado',
                    'data' => [8],
                    // 'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                ],
            ],
            'labels' => ['Procentaje'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y', // Cambiar a barra horizontal
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                ],
            ],
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'color' => 'black', // Cambiar el color del texto
                    'align' => 'end', // Mostrar el texto encima de la barra
                    'anchor' => 'end', // Anclar el texto al final de la barra
                    'formatter' => function ($value, $context) {
                        return $context['dataset']['label']; // Mostrar el label del dataset
                    },
                ],
                'legend' => [
                    'display' => false, // Ocultar la leyenda
                ],
            ],
        ];
    }
}

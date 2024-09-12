<?php

namespace App\Filament\Resources\LogResource\Widgets;

use App\Models\Parameters\Log;
use Filament\Widgets\ChartWidget;

class TopLogsByModuleWidget extends ChartWidget
{
    protected static ?string $heading = 'Top Logs por Módulo';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        // Obtener la cantidad de logs agrupados por la relación logModule
        $logsByModule = Log::with('logModule')
            ->select('log_module_id', \DB::raw('count(*) as count'))
            ->groupBy('log_module_id')
            ->orderByDesc('count')
            ->get();

        // Extraer los nombres de los módulos y las cantidades de logs
        $labels = $logsByModule->map(function ($log) {
            return $log->logModule ? $log->logModule->name : 'Sin módulo'; // Si no hay módulo, colocar "Sin módulo"
        })->toArray();

        $data = $logsByModule->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Logs por Módulo',
                    'data'            => $data, // Cantidad de logs por módulo
                ],
            ],
            'labels' => $labels, // Nombres de los módulos
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

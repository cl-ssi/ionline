<?php

namespace App\Filament\Resources\LogResource\Widgets;

use App\Models\Parameters\Log;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class LogsByModuleChart extends ChartWidget
{
    protected static ?string $heading = 'Logs por Día';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        // Obtener los logs agrupados por día y contar cuántos hay cada día
        $logsPerDay = Log::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Extraer las fechas y los contadores de logs por día
        $labels = $logsPerDay->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d/m/Y'); // Formatear la fecha como día/mes/año
        })->toArray();

        $data = $logsPerDay->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Logs por Día',
                    'data' => $data, // Datos de los logs
                    'backgroundColor' => '#3b82f6', // Color de las barras
                ],
            ],
            'labels' => $labels, // Fechas como etiquetas
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

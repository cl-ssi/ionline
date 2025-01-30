<?php

namespace App\Filament\Exports\IdentifyNeeds;

use App\Models\IdentifyNeeds\IdentifyNeed;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class IdentifyNeedExporter extends Exporter
{
    protected static ?string $model = IdentifyNeed::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID DNC'),
            ExportColumn::make('subject')
                ->label('Nombre de la actividad'),
            ExportColumn::make('strategicAxis.name')
                ->label('Objetivo Estrategico'),
            ExportColumn::make('impactObjective.description')
                ->label('Objetivo de Impacto'),
            ExportColumn::make('availablePlaces.estament.name')
                ->label('Estamentos asociados a la actividad'),
            ExportColumn::make('availablePlaces.places_number')
                ->label('Cupos asociados a la actividad'),
            ExportColumn::make('nature_of_the_need_value')
                ->label('Cupos asociados a la actividad'),
            ExportColumn::make('total_hours')
                ->label('Horas asociadas'),
            ExportColumn::make('mechanism_value')
                ->label('Modalidad'),
            ExportColumn::make('total_value')
                ->label('Presupuesto solicitado'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your identify need export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

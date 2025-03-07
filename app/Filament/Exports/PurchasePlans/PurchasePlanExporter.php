<?php

namespace App\Filament\Exports\PurchasePlans;

use App\Models\PurchasePlan\PurchasePlan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PurchasePlanExporter extends Exporter
{
    protected static ?string $model = PurchasePlan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('status_value')
                ->label('Estado'),
            ExportColumn::make('created_at')
                ->label('Fecha Creación'),
            ExportColumn::make('created_at_year')
                ->label('Periodo')
                ->getStateUsing(fn ($record) => $record->created_at->format('Y')),
            ExportColumn::make('userResponsible.TinyName')
                ->label('Responsable'),
            ExportColumn::make('organizationalUnit.name')
                ->label('Unidad Organizacional'),
            ExportColumn::make('program')
                ->label('Programa'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your purchase plan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

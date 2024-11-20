<?php

namespace App\Filament\Exports\Rrhh;

use App\Models\Rrhh\OvertimeRefund;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OvertimeRefundExporter extends Exporter
{
    protected static ?string $model = OvertimeRefund::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('date'),
            ExportColumn::make('user.full_name'),
            ExportColumn::make('organizationalUnit.name'),
            ExportColumn::make('boss.full_name'),
            ExportColumn::make('boss_position'),
            ExportColumn::make('grado'),
            ExportColumn::make('planta'),
            ExportColumn::make('type.value'),
            // ExportColumn::make('details'),
            ExportColumn::make('total_minutes_day'),
            ExportColumn::make('total_minutes_night'),
            ExportColumn::make('status.value'),
            ExportColumn::make('establishment.name'),
            ExportColumn::make('rrhh_ok'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            // ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your overtime refund export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Exports\Rrhh;

use App\Models\Rrhh\AttendanceRecord;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class AttendanceRecordExporter extends Exporter
{
    protected static ?string $model = AttendanceRecord::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('user.shortName')
                ->label('Nombre'),
            ExportColumn::make('user.id')
                ->label('Run'),
            ExportColumn::make('user.dv')
                ->label('DV'),
            ExportColumn::make('record_date')
                ->label('Fecha')
                ->formatStateUsing(function ($record) {
                    return $record->record_at->format('Y-m-d');
                }),
            ExportColumn::make('record_time')
                ->label('Hora')
                ->formatStateUsing(function ($record) {
                    return $record->record_at->format('H:i');
                }),
            ExportColumn::make('type')
                ->label('Tipo (1 entrada, 0 salida)')
                ->formatStateUsing(function ($state): int {
                    return $state === true ? '1' : '0';
                }),
            ExportColumn::make('observation')
                ->label('Observación'),
            ExportColumn::make('establishment.name')
                ->label('Establecimiento'),
            ExportColumn::make('rrhhUser.shortName')
                ->label('Sirh ingresado por'),
            ExportColumn::make('sirh_at')
                ->label('Sirh ingresado a las'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
            // ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación se ha completado ' . number_format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . ' ' . str('exportada')->plural($export->successful_rows);

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Exports\Documents\Agreements;

use App\Models\Documents\Agreements\Process;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProcessExporter extends Exporter
{
    protected static ?string $model = Process::class;

    public static function getXlsxWriterOptions(): array
    {
        // Start output buffering
        if (ob_get_level() == 0) {
            ob_start();
        }
        
        return [
            'should_use_inline_strings' => true,
            'buffer_size' => 100,
            'pre_calculate_formulas' => false,
            'store_in_memory' => true,
        ];
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('Id'),
            ExportColumn::make('period')
                ->label('Periodo'),
            ExportColumn::make('program.name')
                ->label('Programa'),
            ExportColumn::make('commune.name')
                ->label('Comuna'),
            ExportColumn::make('program.resource_distribution_number')
                ->label('Nº resolución de distribución de recursos'),
            ExportColumn::make('program.resource_distribution_date')
                ->label('Fecha resolución de distribución de recursos')
                ->state(fn ($record) => $record->program?->resource_distribution_date?->format('Y-m-d')),
            ExportColumn::make('days_elapsed')
                ->label('Días transcurridos'),
            ExportColumn::make('created_at')
                ->label('Fecha de creación')
                ->state(fn ($record) => $record->created_at->format('Y-m-d H:i')),
            ExportColumn::make('program.subtitle.name')
                ->label('Subtitulo'),
            ExportColumn::make('total_amount')
                ->label('Monto total'),
            ExportColumn::make('processType.name')
                ->label('Tipo de proceso'),
            ExportColumn::make('sended_revision_lawyer_at')
                ->label('Fecha de envío a revisión jurídico')
                ->state(fn ($record) => $record->sended_revision_lawyer_at?->format('Y-m-d H:i')),
            ExportColumn::make('revision_by_lawyer_at')
                ->label('Revisión por jurídico')
                ->state(fn ($record) => $record->revision_by_lawyer_at?->format('Y-m-d H:i')),
            ExportColumn::make('sended_revision_commune_at')
                ->label('Fecha de envío a revisión por comuna')
                ->state(fn ($record) => $record->sended_revision_commune_at?->format('Y-m-d H:i')),
            ExportColumn::make('revision_by_commune_at')
                ->label('Fecha revisión por comuna')
                ->state(fn ($record) => $record->revision_by_commune_at?->format('Y-m-d H:i')),
            ExportColumn::make('sended_endorses_at')
                ->label('Fecha de envío a vización')
                ->state(fn ($record) => $record->sended_endorses_at?->format('Y-m-d H:i')),
            ExportColumn::make('endorses.initials')
                ->label('Visaciones'),
            ExportColumn::make('endorses.approver_at')
                ->label('Fecha visaciones'),
            ExportColumn::make('sended_to_commune_at')
                ->label('Fecha de envío a comuna')
                ->state(fn ($record) => $record->sended_to_commune_at?->format('Y-m-d H:i')),
            ExportColumn::make('returned_from_commune_at')
                ->label('Fecha de recepción de comuna')
                ->state(fn ($record) => $record->returned_from_commune_at?->format('Y-m-d H:i')),
            ExportColumn::make('approval.created_at')
                ->label('Fecha envío a firma Director')  
                ->state(fn ($record) => $record->approval?->created_at?->format('Y-m-d')),
            ExportColumn::make('approval.approver_at')
                ->label('Fecha firma Director')
                ->state(fn ($record) => $record->approval?->approver_at?->format('Y-m-d')),
            ExportColumn::make('number')
                ->label('Número of partes'),
            ExportColumn::make('date')
                ->label('Fecha de of partes')
                ->state(fn ($record) => $record->date?->format('Y-m-d')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación ha completado y ' . number_format($export->successful_rows) . ' ' . str('registro')->plural($export->successful_rows) . ' exportados.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('registro')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

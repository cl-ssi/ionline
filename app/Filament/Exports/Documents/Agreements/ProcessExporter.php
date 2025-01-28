<?php

namespace App\Filament\Exports\Documents\Agreements;

use App\Models\Documents\Agreements\Process;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProcessExporter extends Exporter
{
    protected static ?string $model = Process::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('process_type_id'),
            ExportColumn::make('period'),
            ExportColumn::make('program.name'),
            ExportColumn::make('commune.name'),
            ExportColumn::make('municipality.name'),
            ExportColumn::make('municipality_name'),
            ExportColumn::make('municipality_rut'),
            ExportColumn::make('municipality_address'),
            ExportColumn::make('mayor.name'),
            ExportColumn::make('mayor_name'),
            ExportColumn::make('mayor_run'),
            ExportColumn::make('mayor_appellative'),
            ExportColumn::make('mayor_decree'),
            ExportColumn::make('total_amount'),
            ExportColumn::make('quotas_qty'),
            ExportColumn::make('establishments'),
            ExportColumn::make('signer.id'),
            ExportColumn::make('signer_appellative'),
            ExportColumn::make('signer_decree'),
            ExportColumn::make('signer_name'),
            ExportColumn::make('number'),
            ExportColumn::make('date'),
            ExportColumn::make('status'),
            ExportColumn::make('document_content'),
            ExportColumn::make('document_date'),
            ExportColumn::make('previousProcess.id'),
            ExportColumn::make('revision_by_lawyer_at'),
            ExportColumn::make('revision_by_lawyer_user_id'),
            ExportColumn::make('revision_by_commune_at'),
            ExportColumn::make('revision_by_commune_user_id'),
            ExportColumn::make('sended_to_commune_at'),
            ExportColumn::make('returned_from_commune_at'),
            ExportColumn::make('establishment.name'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your process export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

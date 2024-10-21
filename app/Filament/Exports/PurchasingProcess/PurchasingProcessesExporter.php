<?php

namespace App\Filament\Exports\PurchasingProcess;

use App\Models\PurchasingProcess\PurchasingProcess;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PurchasingProcessesExporter extends Exporter
{
    protected static ?string $model = PurchasingProcess::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('requestForm.id')
                ->label('ID Form.'),
            ExportColumn::make('requestForm.folio')
                ->label('Folio'),
            ExportColumn::make('requestForm.program')
                ->label('Programa'),
            ExportColumn::make('requestForm.associateProgram.alias_finance')
                ->label('Programa'),
            ExportColumn::make('requestForm.estimated_expense')
                ->label('Presupuesto Form.')
                // ->getStateUsing(fn ($record) => number_format($record->requestForm->estimated_expense, 0, ',', '.'))
                ->formatStateUsing(function ($record) {
                    return number_format($record->requestForm->estimated_expense, 0, ',', '.');
                }),
            ExportColumn::make('requestForm.status')
                ->label('Estado Form.')
                ->formatStateUsing(function ($record) {
                    return $record->requestForm->status->getLabel(); // Llama al método getLabel() del Enum
                }),
            ExportColumn::make('details.product.name')
                ->label('Articulo'),
            ExportColumn::make('details.specification')
                ->label('Especificaciones Técnicas'),
            ExportColumn::make('details.quantity')
                ->label('Cantidad'),
            ExportColumn::make('details.unit_value')
                ->label('Valor Unitario'),
            ExportColumn::make('details.tax')
                ->label('Impuesto'),
            ExportColumn::make('details.expense')
                ->label('Valor Total'),
            ExportColumn::make('status')
                ->label('Estado de Compra')
                ->formatStateUsing(function ($record) {
                    return $record->status->getLabel(); // Llama al método getLabel() del Enum
                }),
            ExportColumn::make('purchasingProcessDetails.immediatePurchase.po_id')
                ->label('OC'),
            ExportColumn::make('purchasingProcessDetails.immediatePurchase.po_supplier_name')
                ->label('Nombre Proveedor'),
            ExportColumn::make('purchasingProcessDetails.immediatePurchase.po_supplier_office_run')
                ->label('RUT Proveedor'),
            ExportColumn::make('purchasingProcessDetails.quantity')
                ->label('Cantidad'),
            ExportColumn::make('purchasingProcessDetails.unit_value')
                ->label('Valor Unitario OC'),
            ExportColumn::make('purchasingProcessDetails.expense')
                ->label('Total Item'),
            ExportColumn::make('total_oc')
                ->label('Total OC')
                ->formatStateUsing(function ($record) {
                    return $record->purchasingProcessDetails->sum('expense');
                }),
            ExportColumn::make('diferencia')
                ->label('Diferencia Presupuesto / OC')
                ->formatStateUsing(function ($record) {
                    $totalPoAmount = $record->purchasingProcessDetails->sum('expense');

                    return $record->requestForm->estimated_expense - $totalPoAmount;
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your purchasing processes export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

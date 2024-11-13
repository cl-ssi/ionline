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
            ExportColumn::make('created_at')
                ->label('Fecha Form.')
                ->formatStateUsing(function ($record) {
                    return $record->created_at ? $record->created_at->format('d-m-Y H:i:s') : null;
                }),
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
                /*
                ->formatStateUsing(function ($record) {
                    foreach($record->details as $detail){
                        return number_format($detail->quantity, 0, ',', '.');
                    }
                }),
                */
            ExportColumn::make('details.unit_value')
                ->label('Valor Unitario'),
                /*
                ->formatStateUsing(function ($record) {
                    foreach($record->details as $detail){
                        return number_format($detail->unit_value, 0, ',', '.');
                    }
                }),
                */
            ExportColumn::make('details.tax')
                ->label('Impuesto'),
            ExportColumn::make('details.expense')
                ->label('Valor Total'),
                /*
                ->formatStateUsing(function ($record) {
                    $detailsRow = [];
                    foreach($record->details as $detail){
                        $detailsRow[] = number_format($detail->expense, 0, ',', '.');
                    }
                    return implode(', ', $detailsRow);
                }),
                */
            ExportColumn::make('status')
                ->label('Estado de Compra')
                ->formatStateUsing(function ($record) {
                    return $record->status->getLabel(); // Llama al método getLabel() del Enum
                }),
            ExportColumn::make('currentPurchasingProcessDetails.immediatePurchase.po_id')
                ->label('OC'),
            ExportColumn::make('currentPurchasingProcessDetails.immediatePurchase.po_supplier_name')
                ->label('Nombre Proveedor'),
            ExportColumn::make('currentPurchasingProcessDetails.immediatePurchase.po_supplier_office_run')
                ->label('RUT Proveedor'),
            ExportColumn::make('currentPurchasingProcessDetails.quantity')
                ->label('Cantidad'),
                /*
                ->formatStateUsing(function ($record) {
                    foreach($record->details as $detail){
                        return number_format($detail->unit_value, 0, ',', '.');
                    }
                }),
                */
            ExportColumn::make('currentPurchasingProcessDetails.unit_value')
                ->label('Valor Unitario OC'),
                /*
                ->formatStateUsing(function ($record) {
                    foreach($record->purchasingProcessDetails as $purchasingProcessDetail){
                        return number_format($purchasingProcessDetail->unit_value, 0, ',', '.');
                    }
                }),
                */
            ExportColumn::make('currentPurchasingProcessDetails.expense')
                ->label('Total Item'),
            ExportColumn::make('total_oc')
                ->label('Total OC')
                ->formatStateUsing(function ($record) {
                    return number_format($record->getExpense(), 0, ',', '.');
                }),
            ExportColumn::make('diferencia')
                ->label('Diferencia Presupuesto / OC')
                ->formatStateUsing(function ($record) {
                    $totalPoAmount = $record->getExpense();

                    return number_format($record->requestForm->estimated_expense - $totalPoAmount, 0, ',', '.');
                }),
        ];
    }

    /*
    public static function export($query, array $columns)
    {
        $rows = [];

        // Recorremos cada registro principal
        foreach ($query->get() as $record) {
            // Recorremos los detalles relacionados (hasMany) y generamos filas individuales
            foreach ($record->details as $detail) {
                $rows[] = [
                    // Datos del PurchasingProcess principal
                    'requestForm.id' => $record->requestForm->id,
                    'requestForm.folio' => $record->requestForm->folio,
                    'requestForm.program' => $record->requestForm->program,
                    'requestForm.estimated_expense' => number_format($record->requestForm->estimated_expense, 0, ',', '.'),
                    'status' => $record->status->getLabel(),

                    // Detalle específico
                    'details.product.name' => $detail->product->name,
                    'details.specification' => $detail->specification,
                    'details.quantity' => $detail->quantity,
                    'details.unit_value' => number_format($detail->unit_value, 0, ',', '.'),
                    'details.expense' => number_format($detail->expense, 0, ',', '.'),
                ];
            }
        }

        // Retornamos las filas individuales generadas para cada detalle
        return static::exportRows($rows, $columns);
    }
    */

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your purchasing processes export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
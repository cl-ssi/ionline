<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\PurchasingProcessResource\Pages;
use App\Filament\Clusters\Finance\Resources\PurchasingProcessResource\RelationManagers;
use App\Models\RequestForms\PurchasingProcess;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\PurchasingProcess\PurchasingProcessesExporter;

class PurchasingProcessResource extends Resource
{
    protected static ?string $model = PurchasingProcess::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = 'Formulario de Compra';

    protected static ?string $pluralModelLabel = 'Formularios de Compra';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('purchase_mechanism_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('purchase_type_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('observation')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('request_form_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(PurchasingProcessesExporter::class)
                    ->label('Exportar')
                    ->modalHeading('Exportar Informe de Procesos de Compra')
                    ->modalSubmitActionLabel('Exportar')
                    ->color('success') // Cambia el color a verde
                    ->icon('heroicon-o-arrow-down-tray') // Cambia a un ícono de Excel, si tienes uno personalizado, puedes usar su ruta
                    ->columnMapping(false),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('requestForm.id')
                    ->label('ID Form.')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('requestForm.folio')
                    ->label('Folio')
                    ->searchable()
                    ->numeric()
                    ->url(fn($record)=>route('request_forms.show', $record->id)),
                Tables\Columns\TextColumn::make('requestForm.program')
                    ->label('Programa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requestForm.associateProgram.alias_finance')
                    ->label('Programa')
                    ->numeric()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('requestForm.estimated_expense')
                    ->label('Presupuesto Form.')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requestForm.status')
                    ->label('Estado Form.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('details.product.name')
                    ->label('Articulo')
                    ->searchable()
                    ->wrap()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('details.specification')
                    ->label('Especificaciones Técnicas')
                    ->searchable()
                    ->wrap()
                    ->bulleted(),
                Tables\Columns\TextColumn::make('details.quantity')
                    ->label('Cantidad')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('details.unit_value')
                    ->label('Valor Unitario')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('details.tax')
                    ->label('Impuesto')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('details.expense')
                    ->label('Valor Total')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado de Compra')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.immediatePurchase.po_id')
                    ->label('OC')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.immediatePurchase.po_supplier_name')
                    ->label('Nombre Proveedor')
                    ->bulleted()
                    ->wrap(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.immediatePurchase.po_supplier_office_run')
                    ->label('RUT Proveedor')
                    ->bulleted()
                    ->wrap(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.quantity')
                    ->label('Cantidad')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.unit_value')
                    ->label('Valor Unitario OC')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted()
                    ->wrap(),
                Tables\Columns\TextColumn::make('purchasingProcessDetails.expense')
                    ->label('Total Item')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted()
                    ->wrap(),

                Tables\Columns\TextColumn::make('total_oc')
                    ->label('Total OC')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted()
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        return $record->purchasingProcessDetails->sum('expense');
                    }),

                Tables\Columns\TextColumn::make('diferencia')
                    ->label('Diferencia Presupuesto / OC')
                    ->money('CLP')
                    ->prefix('$ ')
                    ->bulleted()
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        $totalPoAmount = $record->purchasingProcessDetails->sum('expense');

                        return $record->requestForm->estimated_expense - $totalPoAmount;
                    }),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchasingProcesses::route('/'),
            'create' => Pages\CreatePurchasingProcess::route('/create'),
            'edit' => Pages\EditPurchasingProcess::route('/{record}/edit'),
        ];
    }
}

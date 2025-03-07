<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\PurchasePlanResource\Pages;
use App\Filament\Clusters\Finance\Resources\PurchasePlanResource\RelationManagers;
use App\Models\PurchasePlan\PurchasePlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\PurchasePlans\PurchasePlanExporter;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\Models\Export;


class PurchasePlanResource extends Resource
{
    protected static ?string $model = PurchasePlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static ?string $modelLabel = 'Plan de Compra';

    protected static ?string $pluralModelLabel = 'Planes de Compra';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(PurchasePlanExporter::class)
                    ->label('Exportar')
                    ->color('success')
                    ->icon('heroicon-o-table-cells')
                    ->modalHeading('Exportar Planes de Compras')
                    ->columnMapping(false)
                    ->formats([
                        ExportFormat::Xlsx,
                    ])
                    ->fileName(fn (Export $export): string => "planes-de-compras"),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(fn ($record) => $record->status_value)
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aprobado'                  => 'gray',
                        'Aprobado y Publicado'      => 'success',
                        'Enviado'                   => 'primary',
                        'Guardado'                  => 'info',
                        'Pendiente'                 => 'warning',
                        'Rechazado'                 => 'danger',
                    })
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->dateTime('d-m-Y H:i:s'),
                Tables\Columns\TextColumn::make('created_at_year')
                    ->label('Periodo')
                    ->getStateUsing(fn ($record) => $record->created_at->format('Y')),
                Tables\Columns\TextColumn::make('userResponsible.TinyName')
                    ->label('Responsable'),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad Organizacional'),
                Tables\Columns\TextColumn::make('program')
                    ->label('Programa'),
                Tables\Columns\ImageColumn::make('approvals.avatar')
                    ->label('Aprobaciones')
                    ->circular()
                    ->sortable(),
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
            'index' => Pages\ListPurchasePlans::route('/'),
            'create' => Pages\CreatePurchasePlan::route('/create'),
            'edit' => Pages\EditPurchasePlan::route('/{record}/edit'),
        ];
    }
}

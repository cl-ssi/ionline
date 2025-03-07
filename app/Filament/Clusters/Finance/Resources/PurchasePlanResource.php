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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\TrashedFilter;


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
                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->limit(50) // Limita el texto a 50 caracteres
                    ->tooltip(fn ($record) => $record->subject) // Muestra el texto completo al pasar el mouse,
                    ->searchable(),
                Tables\Columns\TextColumn::make('userResponsible.TinyName')
                    ->label('Responsable')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('userResponsible', function (Builder $subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%{$search}%")
                                     ->orWhere('fathers_family', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('userCreator.TinyName')
                    ->label('Usuario Creador')
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('userResponsible', function (Builder $subQuery) use ($search) {
                            $subQuery->where('name', 'like', "%{$search}%")
                                     ->orWhere('fathers_family', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('organizationalUnit.name')
                    ->label('Unidad Organizacional'),
                Tables\Columns\TextColumn::make('program')
                    ->label('Programa')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('approvals.avatar')
                    ->label('Aprobaciones')
                    ->circular()
                    ->sortable(),
                Tables\Columns\IconColumn::make('deleted_at')
                    ->label('Eliminado')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle') // 🔴 Si está eliminado, muestra X roja
                    ->trueColor('danger') // Rojo
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('date_deleted_at')
                    ->label('Fecha Eliminación')
                    ->getStateUsing(fn ($record) => $record->deleted_at ? $record->deleted_at->format('d-m-Y H:i:s') : ''),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado de Plan')
                    ->options([
                        'approved'  => 'Aprobado',
                        'published' => 'Aprobado y Publicado',
                        'sent'      => 'Enviado',
                        'saved'     => 'Guardado',
                        'rejected'  => 'Rechazado',
                    ])
                    ->multiple()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('organizational_unit_id')
                    ->label('Unidad Organizacional')
                    ->relationship('organizationalUnit','name', fn (Builder $query) => $query->where('establishment_id', auth()->user()->establishment_id))
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('created_at_range')
                    ->label('Periodo de Creación')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Desde')
                            ->native(false), // Esto permite usar el picker de Filament en lugar del nativo del navegador
                        DatePicker::make('end_date')
                            ->label('Hasta')
                            ->native(false),
                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'] ?? null, fn ($q, $start) => $q->whereDate('created_at', '>=', $start))
                            ->when($data['end_date'] ?? null, fn ($q, $end) => $q->whereDate('created_at', '<=', $end));
                    }),
                Tables\Filters\TrashedFilter::make()
            ], layout: FiltersLayout::AboveContent)
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

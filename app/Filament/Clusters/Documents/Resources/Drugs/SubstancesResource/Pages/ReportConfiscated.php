<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource;
use App\Models\Drugs\Reception;
use App\Models\Drugs\ReceptionItem;
use App\Models\Drugs\Substance;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ReportConfiscated extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = SubstancesResource::class;

    protected static string $view = 'filament.clusters.documents.resources.drugs.substances-resource.pages.report-confiscated';

    protected static ?string $title = 'Reporte ISP';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(function (Builder $query) {
                $selectedYear = request('tableFilters')['created_at'] ?? Carbon::now()->year;
                $previousYear = $selectedYear - 1;

                return ReceptionItem::query()
                    ->select('substance_id')
                    ->selectRaw('COUNT(*) as total_items') // Total de ítems por sustancia
                    ->selectRaw(
                        'COUNT(DISTINCT reception_id) as total_receptions'
                    ) // Total de actas únicas (receptions) por sustancia
                    ->selectRaw('SUM(net_weight) as total_net_weight') // Peso neto total
                    ->selectRaw(
                        'SUM(
                            CASE 
                                WHEN result_substance_id IS NULL AND 
                                     (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 
                                THEN 1 ELSE 0 
                            END
                        ) as total_without_result'
                    ) // Total sin sustancia resultante
                    ->selectRaw(
                        'COUNT(DISTINCT CASE 
                            WHEN result_substance_id IS NULL AND 
                                 (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 
                            THEN reception_id ELSE NULL 
                        END) as total_receptions_without_result'
                    ) // Total de actas únicas sin sustancia resultante
                    ->selectRaw(
                        'SUM(
                            CASE 
                                WHEN result_substance_id IS NULL AND 
                                     (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 
                                THEN net_weight ELSE 0 
                            END
                        ) as total_net_weight_without_result'
                    ) // Peso neto total de ítems sin sustancia resultante
                    ->selectRaw(
                        'SUM(
                            CASE 
                                WHEN result_substance_id IS NOT NULL OR 
                                     (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) > 0 
                                THEN net_weight ELSE 0 
                            END
                        ) as total_net_weight_with_result'
                    ) // Peso neto total de ítems con sustancia resultante
                    ->groupBy('substance_id')
                    ->with(['substance']);
            })
            ->columns([
                Tables\Columns\TextColumn::make('substance.name')
                    ->label('Nombre de Sustancia')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total de Items')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_receptions')
                    ->label('Cantidad de Actas')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight')
                    ->label('Recibidos')
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_without_result')
                    ->label('Sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_receptions_without_result')
                    ->label('Actas sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight_without_result')
                    ->label('Peso Neto sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight_with_result')
                    ->label('Peso Neto con Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales
                    ->alignEnd(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('created_at')
                    ->label('Filtrar por Año')
                    ->options( $this->getYearsOptions())
                    ->query(function ($query, $data) {
                        if ($data) {
                            $query->whereHas('reception', function ($query) use ($data) {
                                $query->whereYear('created_at', $data);
                            });
                        }
                    })
                    ->placeholder('Selecciona un Año'),
                Tables\Filters\SelectFilter::make('substance_id')
                    ->label('Filtrar por Sustancia')
                    ->options($this->getSubstanceOptions())
                    ->placeholder('Selecciona una Sustancia')
                    ->searchable() // Agrega el campo de búsqueda
                    ->multiple(),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                // Define aquí tus acciones
            ])
            ->bulkActions([
                // Define aquí tus acciones en bloque
            ]);
    }

    /**
     * Define el ID de sustancia como la clave de cada registro.
     */
    public function getTableRecordKey($record): string
    {
        return (string) $record->substance_id;
    }

    /**
     * Obtiene las opciones para el filtro de sustancias.
     */
    private function getSubstanceOptions(): array
    {
        return Substance::query()
            ->where('presumed', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Obtiene los años disponibles en la base de datos para el filtro de año.
     */
    private function getYearsOptions(): array
    {
        // Obtener todos los años que existan en la columna created_at de Reception
        return Reception::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();
    }
}

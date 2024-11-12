<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource;
use App\Models\Drugs\ReceptionItem;
use App\Models\Drugs\Substance;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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
                $query = ReceptionItem::query()
                    ->select('substance_id')
                    ->selectRaw('COUNT(*) as total_items, SUM(net_weight) as total_net_weight')
                    ->groupBy('substance_id')
                    ->with(['substance','resultSubstance']);

                // // Aplica el filtro de sustancia si está seleccionado
                // if ($substanceId = request('tableFilters')['substance_id'] ?? null) {
                //     $query->where('substance_id', $substanceId);
                // }

                return $query;
            })
            ->columns([
                TextColumn::make('substance_id')
                    ->label('ID de Sustancia')
                    ->sortable(),
                TextColumn::make('substance.name')
                    ->label('Nombre de Sustancia')
                    ->sortable(),
                TextColumn::make('total_items')
                    ->label('Total de Items')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
                TextColumn::make('total_net_weight')
                    ->label('Recibidos')
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
            ])
            ->filters([
                SelectFilter::make('substance_id')
                    ->label('Filtrar por Sustancia')
                    ->options($this->getSubstanceOptions())
                    ->placeholder('Selecciona una Sustancia')
                    ->searchable() // Agrega el campo de búsqueda
                    ->multiple(),
                SelectFilter::make('created_at')
                    ->label('Filtrar por Año')
                    ->options(function () {
                        $currentYear = now()->year;
                        $years = [];
                        for ($i = 0; $i < 10; $i++) {
                            $years[$currentYear - $i] = $currentYear - $i;
                        }
                        return $years;
                    })
                    ->query(function ($query, $data) {
                        if ($data) {
                            $query->whereHas('reception', function ($query) use ($data) {
                                $query->whereYear('created_at', $data);
                            });
                        }
                    })
                    ->placeholder('Selecciona un Año'),
            ], layout: FiltersLayout::AboveContent)
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
        $startYear = ReceptionItem::query()->oldest('created_at')->value('created_at')->year ?? Carbon::now()->year;
        $currentYear = Carbon::now()->year;

        $years = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $years[$year] = $year;
        }

        return $years;
    }
}
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
use Filament\Tables\Actions\Action;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms;

use Filament\Forms\Components\Grid;

use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Exports\Documents\Drugs\ReportConfiscatedExporter;

class ReportConfiscated extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = SubstancesResource::class;

    protected static string $view = 'filament.clusters.documents.resources.drugs.substances-resource.pages.report-confiscated';

    protected static ?string $title = 'Reporte ISP';

    public ?int $year = null;
    public array $selectedSubstances = [];
    public bool $shouldApplyFilters = false;

    public array $destructTotalsBySubstance = [];
    public array $destructGroupedByResultSubstance = [];
    public array $destructReceptionsGroupedByResultSubstance = [];
    public array $netWeightGroupedByResultSubstance = [];
    public array $countersampleGroupedByResultSubstance = [];
    public array $itemsCountGroupedByResultSubstance = [];
    public array $receptionsCountGroupedByResultSubstance = [];


    public function mount(): void
    {
        $this->form->fill([
            'year' => now()->year,
            'selectedSubstances' => [],
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([
                    Forms\Components\Select::make('year')
                        ->label('Año')
                        ->options($this->getYearsOptions())
                        ->required()
                        ->columnSpan(6),

                    Forms\Components\Select::make('selectedSubstances')
                        ->label('Sustancias Presuntas')
                        ->options($this->getSubstanceOptions())
                        ->multiple()
                        ->searchable()
                        ->columnSpan(6),
                ]),
            ])
            ->statePath(null);
    }

    public function applyFilters(): void
    {
        $data = $this->form->getState();

        // Verifica que el año esté presente y sea numérico
        if (empty($data['year']) || !is_numeric($data['year'])) {
            $this->notify('danger', 'Debe seleccionar un año válido antes de aplicar filtros.');
            return;
        }

        $this->year = (int) $data['year'];
        $this->selectedSubstances = $data['selectedSubstances'] ?? [];
        $this->shouldApplyFilters = true;

        /*
        $this->destructTotalsBySubstance = $this->getDestructWeightBySubstance();
        $this->destructGroupedByResultSubstance = $this->getDestructGroupedByResultSubstance();
        $this->destructReceptionsGroupedByResultSubstance = $this->getDestructReceptionsByResultSubstance();
        $this->netWeightGroupedByResultSubstance = $this->getNetWeightGroupedByResultSubstance();
        $this->countersampleGroupedByResultSubstance = $this->getCountersampleGroupedByResultSubstance();
        */

        $this->calculateMetrics();
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(function (Builder $query) {
                if (!$this->shouldApplyFilters || !$this->year) {
                    // Evita ejecutar la query si no hay año válido o no se ha aplicado el filtro
                    return ReceptionItem::query()->whereRaw('1 = 0'); // Retorna nada
                }

                $start = Carbon::create($this->year - 1)->startOfYear()->format('Y-m-d');
                $end = Carbon::create($this->year - 1)->endOfYear()->format('Y-m-d');

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
                    ->selectRaw("
                        SUM(
                            CASE 
                                WHEN countersample_number > 0 
                                    THEN countersample * countersample_number
                                ELSE countersample
                            END
                        ) as total_countersample
                    ")
                    ->selectRaw('SUM(destruct) as total_destruct')
                    ->when($this->shouldApplyFilters, function ($query) {
                        $query->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year));
                
                        if (!empty($this->selectedSubstances)) {
                            $query->whereIn('substance_id', $this->selectedSubstances);
                        }
                    })
                    ->groupBy('substance_id')
                    ->with(['substance']);
            })
            ->columns([
                Tables\Columns\TextColumn::make('substance.name')
                    ->label('Nombre de Sustancia')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_items')
                    ->label('Total Items')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_receptions')
                    ->label('Total Actas')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight')
                    ->label('P. Recibido')
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales,
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_without_result')
                    ->label('Items Sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_receptions_without_result')
                    ->label('Actas sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight_without_result')
                    ->label('P. Neto sin Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_net_weight_with_result')
                    ->label('P. Neto con Sustancia Resultante')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.')) // Formato con separación de miles y 2 decimales
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_countersample') // Nueva columna
                    ->label('Total de Contramuestras')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total_destruct')
                    ->label('Cantidad por Destruir')
                    ->sortable()
                    ->formatStateUsing(fn (string|float $state): string => number_format($state, 2, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('substance_id')
                    ->label('Cantidad Destruida')
                    ->getStateUsing(function ($record) {
                        return $this->destructTotalsBySubstance[$record->substance_id] ?? 0;
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('result_substance_name')
                    ->label('Sustancias Resultantes')
                    ->getStateUsing(function ($record) {
                        $items = $this->destructGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)
                            ->pluck('name')
                            ->filter() // quita null o vacíos
                            ->map(fn ($name) => (string) $name)
                            ->all();
                    })
                    ->bulleted()
                    ->extraAttributes(['class' => 'whitespace-nowrap']),
                Tables\Columns\TextColumn::make('items_by_result_substance')
                    ->label('Total Ítems por Sustancia Resultante')
                    ->getStateUsing(function ($record) {
                        $items = $this->itemsCountGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)->map(function ($item) {
                            return number_format($item['items'], 0, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('receptions_by_result_substance')
                    ->label('Actas por Sustancia Resultante')
                    ->getStateUsing(function ($record) {
                        $items = $this->receptionsCountGroupedByResultSubstance[$record->substance_id] ?? [];

                        return collect($items)->map(function ($item) {
                            return number_format($item['actas'], 0, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('net_weight_by_result_substance')
                    ->label('P. Neto por Sustancia Resultante')
                    ->getStateUsing(function ($record) {
                        $items = $this->netWeightGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)->map(function ($item) {
                            return number_format($item['net_weight'], 2, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('countersample_by_result_substance')
                    ->label('P. Contramuestras por Sustancia Resultante')
                    ->getStateUsing(function ($record) {
                        $items = $this->countersampleGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)->map(function ($item) {
                            return number_format($item['countersample_total'], 2, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('result_substance_weight')
                    ->label('P. Destruidos por Resultado')
                    ->getStateUsing(function ($record) {
                        $items = $this->destructGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)->map(function ($item) {
                            return number_format($item['destruct'], 2, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('result_substance_receptions')
                    ->label('Total Actas de Destrucción')
                    ->getStateUsing(function ($record) {
                        $items = $this->destructReceptionsGroupedByResultSubstance[$record->substance_id] ?? [];
                
                        return collect($items)->map(function ($item) {
                            return number_format($item['actas'], 0, ',', '.');
                        })->all();
                    })
                    ->bulleted()
                    ->alignEnd(),
            ])
            ->headerActions([
                /*
                Action::make('export')
                    ->label('Exportar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->icon('heroicon-o-table-cells')
                    ->action(function () {
                        $data = $this->getExportData();

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\Drugs\ReportConfiscatedExport($data),
                            'reporte_isp_' . $this->year . '.xlsx'
                        );
                    }),
                */
        ]) 
            ->filters([
                //
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

    /*
     * Obtiene el peso de destrucción por sustancia.
     *
    private function getDestructWeightBySubstance(): array
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return [];
        }

        $query = ReceptionItem::with('reception')
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed())
            ->groupBy('substance_id')
            ->map(fn ($group) => $group->sum('destruct'))
            ->toArray();

        return $query;
    }

    /**
     * Obtiene los datos de destrucción agrupados por sustancia resultante.
     *
    private function getDestructGroupedByResultSubstance(): array
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return [];
        }

        return ReceptionItem::with(['reception', 'resultSubstance'])
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->whereNotNull('result_substance_id')
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed())
            ->groupBy('substance_id')
            ->map(function ($itemsBySubstance) {
                return $itemsBySubstance
                    ->groupBy('result_substance_id')
                    ->map(function ($group) {
                        return [
                            'name' => $group->first()?->resultSubstance?->name ?? '(Sin nombre)',
                            'destruct' => $group->sum('destruct'),
                        ];
                    })
                    ->values();
            })
            ->toArray();
    }

    /**
     * Obtiene los actas de destrucción agrupados por sustancia resultante.
     *
    private function getDestructReceptionsByResultSubstance(): array
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return [];
        }

        return ReceptionItem::with(['reception'])
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->whereNotNull('result_substance_id')
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed())
            ->groupBy('substance_id')
            ->map(function ($itemsBySubstance) {
                return $itemsBySubstance
                    ->groupBy('result_substance_id')
                    ->map(function ($group) {
                        $actas = $group->pluck('reception_id')->unique()->count();

                        return [
                            'name' => $group->first()?->resultSubstance?->name ?? '(Sin nombre)',
                            'actas' => $actas,
                        ];
                    })
                    ->values();
            })
            ->toArray();
    }

    /**
     * Obtiene el peso neto agrupado por sustancia resultante.
     *
    private function getNetWeightGroupedByResultSubstance(): array
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return [];
        }

        return ReceptionItem::with(['reception', 'resultSubstance'])
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->whereNotNull('result_substance_id')
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed())
            ->groupBy('substance_id')
            ->map(function ($itemsBySubstance) {
                return $itemsBySubstance
                    ->groupBy('result_substance_id')
                    ->map(function ($group) {
                        return [
                            'name' => $group->first()?->resultSubstance?->name ?? '(Sin nombre)',
                            'net_weight' => $group->sum('net_weight'),
                        ];
                    })
                    ->values();
            })
            ->toArray();
    }

    /**
     * Obtiene las contramuestras agrupadas por sustancia resultante.
     *
    private function getCountersampleGroupedByResultSubstance(): array
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return [];
        }

        return ReceptionItem::with(['reception', 'resultSubstance'])
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->whereNotNull('result_substance_id')
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed())
            ->groupBy('substance_id')
            ->map(function ($itemsBySubstance) {
                return $itemsBySubstance
                    ->groupBy('result_substance_id')
                    ->map(function ($group) {
                        return [
                            'name' => $group->first()?->resultSubstance?->name ?? '(Sin nombre)',
                            'countersample_total' => $group->sum(fn ($item) =>
                                $item->countersample_number > 0
                                    ? $item->countersample * $item->countersample_number
                                    : $item->countersample
                            ),
                        ];
                    })
                    ->values();
            })
            ->toArray();
    }

    /**
     * Obtiene los datos para la exportación.
     */

     private function getFilteredReceptionItems(): \Illuminate\Support\Collection
    {
        return ReceptionItem::with(['reception', 'resultSubstance'])
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->where(function ($q) {
                $q->whereNotNull('result_substance_id')
                ->orWhereHas('protocols'); // si quieres mantener esa lógica
            })
            ->when($this->selectedSubstances, fn ($q) =>
                $q->whereIn('substance_id', $this->selectedSubstances)
            )
            ->get()
            ->filter(fn ($item) => $item->reception && $item->reception->wasDestructed());
    }

    private function calculateMetrics()
    {
        $items = $this->getFilteredReceptionItems();

        $this->destructTotalsBySubstance = $items
            ->groupBy('substance_id')
            ->map(fn ($group) => $group->sum('destruct'))
            ->toArray();

        $this->destructGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'destruct' => $g->sum('destruct'),
                ])->values()
            )->toArray();

        $this->destructReceptionsGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'actas' => $g->pluck('reception_id')->unique()->count(),
                ])->values()
            )->toArray();

        $this->netWeightGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'net_weight' => $g->sum('net_weight'),
                ])->values()
            )->toArray();

        $this->countersampleGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'countersample_total' => $g->sum(fn ($item) =>
                        $item->countersample_number > 0
                            ? $item->countersample * $item->countersample_number
                            : $item->countersample
                    ),
                ])->values()
            )->toArray();

        $this->itemsCountGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'items' => $g->count(),
                ])->values()
            )->toArray();
        
        $this->receptionsCountGroupedByResultSubstance = $items
            ->whereNotNull('result_substance_id')
            ->groupBy('substance_id')
            ->map(fn ($group) =>
                $group->groupBy('result_substance_id')->map(fn ($g) => [
                    'name' => $g->first()?->resultSubstance?->name ?? '(Sin nombre)',
                    'actas' => $g->pluck('reception_id')->unique()->count(),
                ])->values()
            )->toArray();
    }


    private function getExportData(): \Illuminate\Support\Collection
    {
        if (!$this->shouldApplyFilters || !$this->year) {
            return collect();
        }

        $destructByPresumed = $this->getDestructWeightBySubstance();

        $destructByResult = $this->getDestructGroupedByResultSubstance();

        $presumedMetrics = ReceptionItem::query()
            ->select('substance_id')
            ->selectRaw('COUNT(*) as total_items')
            ->selectRaw('COUNT(DISTINCT reception_id) as total_receptions')
            ->selectRaw('SUM(net_weight) as total_net_weight')
            ->selectRaw('SUM(CASE WHEN result_substance_id IS NULL AND 
                (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 THEN 1 ELSE 0 END) as total_without_result')
            ->selectRaw('COUNT(DISTINCT CASE WHEN result_substance_id IS NULL AND 
                (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 THEN reception_id ELSE NULL END) as total_receptions_without_result')
            ->selectRaw('SUM(CASE WHEN result_substance_id IS NULL AND 
                (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) = 0 THEN net_weight ELSE 0 END) as total_net_weight_without_result')
            ->selectRaw('SUM(CASE WHEN result_substance_id IS NOT NULL OR 
                (SELECT COUNT(*) FROM drg_protocols WHERE drg_protocols.reception_item_id = drg_reception_items.id) > 0 THEN net_weight ELSE 0 END) as total_net_weight_with_result')
            ->selectRaw('SUM(CASE WHEN countersample_number > 0 THEN countersample * countersample_number ELSE countersample END) as total_countersample')
            ->selectRaw('SUM(destruct) as total_destruct')
            ->with('substance')
            ->whereHas('reception', fn ($q) => $q->whereYear('date', $this->year))
            ->when($this->selectedSubstances, fn ($query) =>
                $query->whereIn('substance_id', $this->selectedSubstances)
            )
            ->groupBy('substance_id')
            ->get();

        return $presumedMetrics->map(function ($item) use ($destructByResult, $destructByPresumed) {
            $substanceId = $item->substance_id;

            $resultList = collect($destructByResult[$substanceId] ?? []);
            $resultText = $resultList
                ->map(fn ($res) => $res['name'] . ': ' . number_format($res['destruct'], 2, ',', '.') . ' g')
                ->implode('; ');

            $totalDestruido = $destructByPresumed[$substanceId] ?? 0;
            $totalPorDestruir = $item->total_destruct ?? 0;

            return [
                'Nombre de Sustancia' => $item->substance->name ?? '(Sin nombre)',
                'Total de Items' => $item->total_items,
                'Cantidad de Actas' => $item->total_receptions,
                'Recibidos' => round($item->total_net_weight ?? 0, 2),
                'Sin Sustancia Resultante' => $item->total_without_result,
                'Actas sin Sustancia Resultante' => $item->total_receptions_without_result,
                'Peso Neto sin Sustancia Resultante' => round($item->total_net_weight_without_result ?? 0, 2),
                'Peso Neto con Sustancia Resultante' => round($item->total_net_weight_with_result ?? 0, 2),
                'Total de Contramuestras' => round($item->total_countersample ?? 0, 2),
                'Cantidad por Destruir' => round($totalPorDestruir, 2),
                'Cantidad Destruida' => round($totalDestruido, 2),
                'Sustancias Resultantes (Destruidas)' => $resultText,
            ];
        });
    }
}

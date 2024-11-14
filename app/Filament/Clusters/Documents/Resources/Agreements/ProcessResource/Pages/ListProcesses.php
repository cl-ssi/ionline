<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Models\Documents\Agreements\Process;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProcesses extends ListRecords
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Obtener todos los períodos distintos de la tabla agr_processes
        $periods = Process::select('period')
            ->distinct()
            ->where('period', '>', now()->year - 5)
            ->orderBy('period', 'desc')
            ->pluck('period');

        // Crear las pestañas dinámicamente
        $tabs = [];

        foreach ($periods as $period) {
            $tabs[$period] = Tab::make()
                ->label($period)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('period', $period));
        }

        // Agregar una pestaña para todos los períodos
        $tabs['todos'] = Tab::make()
            ->label('Todos los Periodos')
            ->modifyQueryUsing(fn (Builder $query) => $query);

        return $tabs;
    }
}

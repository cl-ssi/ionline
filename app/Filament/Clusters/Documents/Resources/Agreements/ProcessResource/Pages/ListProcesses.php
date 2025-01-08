<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use App\Models\Documents\Agreements\Process;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProcesses extends ListRecords
{
    protected static string $resource = ProcessResource::class;

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

        
        if(auth()->user()->can('Agreement: admin')) {
            /** Muestra todos los proceso por año de todos los referentes */
            foreach ($periods as $period) {
                $tabs[$period] = Tab::make()
                    ->label($period)
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('period', $period));
            }
        }
        else {
            /** Muestra todos los proceso por año filtrados para que vea los que perteneces solo al referente */
            foreach ($periods as $period) {
                $tabs[$period] = Tab::make()
                    ->label($period)
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('period', $period)->whereHas('program.referers', function (Builder $query) {
                        $query->where('user_id', auth()->id());
                    }));
            }
        }


        // Agregar una pestaña para todos los períodos
        $tabs['todos'] = Tab::make()
            ->label('Todos')
            ->modifyQueryUsing(fn (Builder $query) => $query);

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

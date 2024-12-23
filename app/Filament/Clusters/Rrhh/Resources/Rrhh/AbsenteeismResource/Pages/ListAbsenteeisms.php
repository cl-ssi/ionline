<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAbsenteeisms extends ListRecords
{
    protected static string $resource = AbsenteeismResource::class;

    public function getTabs(): array
    {
        return [

            'mis_ausentismos' => Tab::make('Mis Ausentismos')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('rut', auth()->id())),

            'ausentismos_unidad' => Tab::make('Ausentismos de mi unidad')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('codigo_unidad', auth()->user()->organizationalUnit->sirh_ou_id)),

            'all' => Tab::make('Todos')
                ->modifyQueryUsing(fn(Builder $query) => $query),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

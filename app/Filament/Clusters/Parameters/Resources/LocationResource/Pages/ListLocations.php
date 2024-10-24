<?php

namespace App\Filament\Clusters\Parameters\Resources\LocationResource\Pages;

use App\Filament\Clusters\Parameters\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLocations extends ListRecords
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Mi Establecimiento' => Tab::make('Mi Establecimiento')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('establishment_id', auth()->user()->establishment_id)),
            'Todos Los Establecimientos' => Tab::make(),
        ];
    }
}

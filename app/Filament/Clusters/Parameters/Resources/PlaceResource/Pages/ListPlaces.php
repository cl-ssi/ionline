<?php

namespace App\Filament\Clusters\Parameters\Resources\PlaceResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PlaceResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPlaces extends ListRecords
{
    protected static string $resource = PlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'De mi establecimiento' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('establishment_id', auth()->user()->establishment_id)),
            'Todos' => Tab::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Documents\Resources\ParteResource\Pages;

use App\Filament\Clusters\Documents\Resources\ParteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPartes extends ListRecords
{
    protected static string $resource = ParteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {   
        return [
            auth()->user()->establishment->name => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('establishment_id', auth()->user()->establishment_id)),
                //'all' => Tab::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Parameters\Resources\AbsenteeismTypeResource\Pages;

use App\Filament\Clusters\Parameters\Resources\AbsenteeismTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsenteeismTypes extends ListRecords
{
    protected static string $resource = AbsenteeismTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

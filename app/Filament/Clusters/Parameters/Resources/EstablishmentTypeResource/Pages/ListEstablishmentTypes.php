<?php

namespace App\Filament\Clusters\Parameters\Resources\EstablishmentTypeResource\Pages;

use App\Filament\Clusters\Parameters\Resources\EstablishmentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstablishmentTypes extends ListRecords
{
    protected static string $resource = EstablishmentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

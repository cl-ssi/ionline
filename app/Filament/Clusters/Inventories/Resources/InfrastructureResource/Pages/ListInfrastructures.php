<?php

namespace App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Pages;

use App\Filament\Clusters\Inventories\Resources\InfrastructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfrastructures extends ListRecords
{
    protected static string $resource = InfrastructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

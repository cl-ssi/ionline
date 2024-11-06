<?php

namespace App\Filament\Clusters\Inventories\Resources\VehicleResource\Pages;

use App\Filament\Clusters\Inventories\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

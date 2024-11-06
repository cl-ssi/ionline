<?php

namespace App\Filament\Clusters\Inventories\Resources\VehicleResource\Pages;

use App\Filament\Clusters\Inventories\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicle extends EditRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

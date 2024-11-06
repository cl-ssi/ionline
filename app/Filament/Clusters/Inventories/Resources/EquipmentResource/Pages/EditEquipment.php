<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Pages;

use App\Filament\Clusters\Inventories\Resources\EquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipment extends EditRecord
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

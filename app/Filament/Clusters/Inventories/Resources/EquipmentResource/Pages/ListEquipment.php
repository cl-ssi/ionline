<?php

namespace App\Filament\Clusters\Inventories\Resources\EquipmentResource\Pages;

use App\Filament\Clusters\Inventories\Resources\EquipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets\MedicalEquipmentOverview;
use App\Filament\Clusters\Inventories\Resources\EquipmentResource\Widgets\IndustrialEquipmentOverview;

class ListEquipment extends ListRecords
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MedicalEquipmentOverview::class,
            IndustrialEquipmentOverview::class,
        ];
    }
}

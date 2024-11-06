<?php

namespace App\Filament\Clusters\Inventories\Resources\InfrastructureResource\Pages;

use App\Filament\Clusters\Inventories\Resources\InfrastructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfrastructure extends EditRecord
{
    protected static string $resource = InfrastructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Parameters\Resources\CommuneResource\Pages;

use App\Filament\Clusters\Parameters\Resources\CommuneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommune extends EditRecord
{
    protected static string $resource = CommuneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Parameters\Resources\EstablishmentResource\Pages;

use App\Filament\Clusters\Parameters\Resources\EstablishmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstablishment extends EditRecord
{
    protected static string $resource = EstablishmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

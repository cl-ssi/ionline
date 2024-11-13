<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\MunicipalityResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\MunicipalityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMunicipality extends EditRecord
{
    protected static string $resource = MunicipalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

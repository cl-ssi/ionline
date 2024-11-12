<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\PoliceUnitResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\PoliceUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoliceUnit extends EditRecord
{
    protected static string $resource = PoliceUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

<?php

namespace App\Filament\Clusters\Parameters\Resources\ProfessionResource\Pages;

use App\Filament\Clusters\Parameters\Resources\ProfessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfession extends EditRecord
{
    protected static string $resource = ProfessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\TalentManagement\Resources\Clusters\TalentManagementResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\Clusters\TalentManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalentManagement extends EditRecord
{
    protected static string $resource = TalentManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

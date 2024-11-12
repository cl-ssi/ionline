<?php

namespace App\Filament\Clusters\TalentManagement\Resources\Clusters\TalentManagementResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\Clusters\TalentManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalentManagement extends ListRecords
{
    protected static string $resource = TalentManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

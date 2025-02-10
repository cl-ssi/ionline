<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\CompetencyResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\CompetencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompetency extends EditRecord
{
    protected static string $resource = CompetencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

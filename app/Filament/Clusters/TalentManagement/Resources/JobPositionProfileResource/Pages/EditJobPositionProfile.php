<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobPositionProfile extends EditRecord
{
    protected static string $resource = JobPositionProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

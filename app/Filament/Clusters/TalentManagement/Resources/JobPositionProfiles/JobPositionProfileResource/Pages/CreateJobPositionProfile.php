<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPositionProfile extends CreateRecord
{
    protected static string $resource = JobPositionProfileResource::class;
}

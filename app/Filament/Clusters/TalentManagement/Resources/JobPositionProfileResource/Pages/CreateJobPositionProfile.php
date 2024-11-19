<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPositionProfile extends CreateRecord
{
    protected static string $resource = JobPositionProfileResource::class;
}

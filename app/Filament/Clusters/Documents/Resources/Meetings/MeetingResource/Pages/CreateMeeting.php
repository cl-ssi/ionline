<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;
}

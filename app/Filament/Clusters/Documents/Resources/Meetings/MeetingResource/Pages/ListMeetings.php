<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeetings extends ListRecords
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

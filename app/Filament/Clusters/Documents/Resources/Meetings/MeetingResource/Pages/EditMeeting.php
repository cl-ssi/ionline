<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

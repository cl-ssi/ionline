<?php

namespace App\Filament\Resources\Sgr\EventTypeResource\Pages;

use App\Filament\Resources\Sgr\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventType extends ViewRecord
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

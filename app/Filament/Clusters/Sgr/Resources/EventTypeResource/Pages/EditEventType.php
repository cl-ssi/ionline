<?php

namespace App\Filament\Clusters\Sgr\Resources\EventTypeResource\Pages;

use App\Filament\Clusters\Sgr\Resources\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventType extends EditRecord
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

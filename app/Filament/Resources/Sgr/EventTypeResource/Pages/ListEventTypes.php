<?php

namespace App\Filament\Resources\Sgr\EventTypeResource\Pages;

use App\Filament\Resources\Sgr\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventTypes extends ListRecords
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

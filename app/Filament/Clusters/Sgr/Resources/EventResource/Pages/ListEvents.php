<?php

namespace App\Filament\Clusters\Sgr\Resources\EventResource\Pages;

use App\Filament\Clusters\Sgr\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

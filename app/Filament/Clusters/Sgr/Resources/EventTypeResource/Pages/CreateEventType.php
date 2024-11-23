<?php

namespace App\Filament\Clusters\Sgr\Resources\EventTypeResource\Pages;

use App\Filament\Clusters\Sgr\Resources\EventTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEventType extends CreateRecord
{
    protected static string $resource = EventTypeResource::class;
}

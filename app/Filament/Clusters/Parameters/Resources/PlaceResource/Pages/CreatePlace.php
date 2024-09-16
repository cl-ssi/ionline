<?php

namespace App\Filament\Clusters\Parameters\Resources\PlaceResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PlaceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;

    protected function getRedirectUrl(): string 
    { 
        return $this->getResource()::getUrl('index'); 
    }
}

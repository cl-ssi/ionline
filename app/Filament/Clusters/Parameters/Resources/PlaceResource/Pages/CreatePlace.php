<?php

namespace App\Filament\Clusters\Parameters\Resources\PlaceResource\Pages;

use App\Filament\Clusters\Parameters\Resources\PlaceResource;
use App\Models\Parameters\Location;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;

    protected function getRedirectUrl(): string 
    { 
        return $this->getResource()::getUrl('index'); 
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['establishment_id'] = Location::find($data['location_id'])?->establishment_id;
    
        return $data;
    }
}

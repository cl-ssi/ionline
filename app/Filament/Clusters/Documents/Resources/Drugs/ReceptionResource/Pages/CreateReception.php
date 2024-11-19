<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReception extends CreateRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}

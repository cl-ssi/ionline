<?php

namespace App\Filament\Clusters\Drugs\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Drugs\Resources\ReceptionResource;
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

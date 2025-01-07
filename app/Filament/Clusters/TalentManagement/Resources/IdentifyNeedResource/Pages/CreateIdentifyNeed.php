<?php

namespace App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIdentifyNeed extends CreateRecord
{
    protected static string $resource = IdentifyNeedResource::class;

    //AGREGA DATOS QUE NO ESTAN EN EL FORM. AL OBJETO LUEGO DE CREAR
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id']    = auth()->id();
        $data['status']     = 'saved'; // Establece el valor predeterminado del campo 'status'

        return $data;
    }
}

<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;

    //AGREGA DATOS QUE NO ESTAN EN EL FORM. AL OBJETO LUEGO DE CREAR
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status']             = 'saved'; // Establece el valor predeterminado del campo 'status'
        $data['user_creator_id']    = auth()->id();
        $data['ou_responsible_id']  = auth()->user()->establishment_id;

        return $data;
    }
}

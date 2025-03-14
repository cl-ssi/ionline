<?php

namespace App\Filament\Clusters\TalentManagement\Resources\TrainingResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTraining extends CreateRecord
{
    protected static string $resource = TrainingResource::class;

    //AGREGA DATOS QUE NO ESTAN EN EL FORM. AL OBJETO LUEGO DE CREAR
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status']                 = 'saved';
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;
        $data['establishment_id']       = auth()->user()->establishment_id;
        
        return $data;
    }
}

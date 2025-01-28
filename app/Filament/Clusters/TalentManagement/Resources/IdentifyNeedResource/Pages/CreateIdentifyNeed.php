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
        $data['status']                 = 'saved';
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;
        $data['establishment_id']       = auth()->user()->establishment_id;
        $data['establishment_name']     = auth()->user()->establishment->name;
        $data['boss_id']                = auth()->user()->boss->id;

        // CALCULAR EL TOTAL
        $data['total_value']            = $data['coffee_break_price'] + $data['transport_price'] + $data['accommodation_price'] + $data['activity_value'];


        return $data;
    }
}

<?php

namespace App\Filament\Extranet\Resources\IdentifyNeedResource\Pages;

use App\Filament\Extranet\Resources\IdentifyNeedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Rrhh\Authority;
use App\Models\Parameters\Parameter;
use Illuminate\Support\Facades\Auth;

class CreateIdentifyNeed extends CreateRecord
{
    protected static string $resource = IdentifyNeedResource::class;

    //AGREGA DATOS QUE NO ESTAN EN EL FORM. AL OBJETO LUEGO DE CREAR
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $bossUser = Authority::getAuthorityFromDate(Parameter::get('ou', 'DireccionAPS', Auth::user()->establishment_id), now(), 'manager');

        $data['status']                 = 'saved';
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;
        $data['establishment_id']       = auth()->user()->establishment_id;
        $data['establishment_name']     = auth()->user()->establishment->name;
        $data['boss_id']                = $bossUser->user_id;
        $data['boss_email']             = $bossUser->user->email;

        // CALCULAR EL TOTAL
        $data['total_value']            = $data['coffee_break_price'] + $data['transport_price'] + $data['accommodation_price'] + $data['activity_value'];
        
        return $data;
    }
}

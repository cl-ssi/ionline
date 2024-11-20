<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsenteeism extends CreateRecord
{
    protected static string $resource = AbsenteeismResource::class;

    protected static ?string $title = 'Crear Ausentismo';
}

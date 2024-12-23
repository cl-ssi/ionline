<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsenteeism extends EditRecord
{
    protected static string $resource = AbsenteeismResource::class;

    protected static ?string $title = 'Editar Ausentismo';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

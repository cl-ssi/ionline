<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProgram extends CreateRecord
{
    protected static string $resource = ProgramResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_program'] = true;
    
        return $data;
    }
}

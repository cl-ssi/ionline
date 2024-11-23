<?php

namespace App\Filament\Clusters\Sgr\Resources\RequirementResource\Pages;

use App\Filament\Clusters\Sgr\Resources\RequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequirement extends CreateRecord
{
    protected static string $resource = RequirementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;
        $data['establishment_id'] = auth()->user()->establishment_id;
        $data['event_type_id'] = 1;
        $data['user_id'] = auth()->id();

        // dd($data);
        return $data;
    }
}

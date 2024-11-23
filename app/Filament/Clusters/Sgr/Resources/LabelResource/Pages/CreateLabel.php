<?php

namespace App\Filament\Clusters\Sgr\Resources\LabelResource\Pages;

use App\Filament\Clusters\Sgr\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLabel extends CreateRecord
{
    protected static string $resource = LabelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;

        return $data;
    }
}

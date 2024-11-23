<?php

namespace App\Filament\Clusters\Sgr\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Sgr\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['organizational_unit_id'] = auth()->user()->organizational_unit_id;

        return $data;
    }
}

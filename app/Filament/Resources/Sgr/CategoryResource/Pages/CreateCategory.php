<?php

namespace App\Filament\Resources\Sgr\CategoryResource\Pages;

use App\Filament\Resources\Sgr\CategoryResource;
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

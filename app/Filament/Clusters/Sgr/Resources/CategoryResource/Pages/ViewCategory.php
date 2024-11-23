<?php

namespace App\Filament\Clusters\Sgr\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Sgr\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

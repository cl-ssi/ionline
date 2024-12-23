<?php

namespace App\Filament\Clusters\Sgr\Resources\LabelResource\Pages;

use App\Filament\Clusters\Sgr\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLabel extends ViewRecord
{
    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Sgr\Resources\RequirementResource\Pages;

use App\Filament\Clusters\Sgr\Resources\RequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRequirement extends ViewRecord
{
    protected static string $resource = RequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Sgr\RequirementResource\Pages;

use App\Filament\Resources\Sgr\RequirementResource;
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

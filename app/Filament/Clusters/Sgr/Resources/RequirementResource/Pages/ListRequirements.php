<?php

namespace App\Filament\Clusters\Sgr\Resources\RequirementResource\Pages;

use App\Filament\Clusters\Sgr\Resources\RequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequirements extends ListRecords
{
    protected static string $resource = RequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

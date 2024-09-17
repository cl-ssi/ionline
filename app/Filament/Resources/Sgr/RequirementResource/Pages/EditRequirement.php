<?php

namespace App\Filament\Resources\Sgr\RequirementResource\Pages;

use App\Filament\Resources\Sgr\RequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequirement extends EditRecord
{
    protected static string $resource = RequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

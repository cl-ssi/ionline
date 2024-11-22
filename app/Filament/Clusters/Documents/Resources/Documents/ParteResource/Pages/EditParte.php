<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ParteResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ParteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParte extends EditRecord
{
    protected static string $resource = ParteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Documents\Resources\ParteResource\Pages;

use App\Filament\Clusters\Documents\Resources\ParteResource;
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

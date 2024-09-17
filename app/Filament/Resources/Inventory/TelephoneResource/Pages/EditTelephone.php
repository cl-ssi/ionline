<?php

namespace App\Filament\Resources\Inventory\TelephoneResource\Pages;

use App\Filament\Resources\Inventory\TelephoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTelephone extends EditRecord
{
    protected static string $resource = TelephoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

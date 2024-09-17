<?php

namespace App\Filament\Resources\Inventory\TelephoneResource\Pages;

use App\Filament\Resources\Inventory\TelephoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTelephones extends ListRecords
{
    protected static string $resource = TelephoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

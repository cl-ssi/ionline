<?php

namespace App\Filament\Resources\TelephoneResource\Pages;

use App\Filament\Resources\TelephoneResource;
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

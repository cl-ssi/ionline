<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReception extends EditRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

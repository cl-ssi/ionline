<?php

namespace App\Filament\Clusters\Drugs\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Drugs\Resources\ReceptionResource;
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

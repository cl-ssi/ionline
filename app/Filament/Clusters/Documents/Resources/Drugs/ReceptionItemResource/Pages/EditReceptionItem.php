<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceptionItem extends EditRecord
{
    protected static string $resource = ReceptionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

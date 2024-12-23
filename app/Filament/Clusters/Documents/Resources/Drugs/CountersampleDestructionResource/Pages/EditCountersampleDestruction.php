<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCountersampleDestruction extends EditRecord
{
    protected static string $resource = CountersampleDestructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

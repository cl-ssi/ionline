<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessTypeResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcessType extends EditRecord
{
    protected static string $resource = ProcessTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Finance\Resources\DteResource\Pages;

use App\Filament\Clusters\Finance\Resources\DteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDte extends EditRecord
{
    protected static string $resource = DteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

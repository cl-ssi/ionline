<?php

namespace App\Filament\Clusters\Parameters\Resources\NewsResource\Pages;

use App\Filament\Clusters\Parameters\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

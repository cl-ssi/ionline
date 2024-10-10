<?php

namespace App\Filament\Clusters\Indicators\Resources\ApsResource\Pages;

use App\Filament\Clusters\Indicators\Resources\ApsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAps extends EditRecord
{
    protected static string $resource = ApsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

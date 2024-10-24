<?php

namespace App\Filament\Clusters\Parameters\Resources\AccessLogResource\Pages;

use App\Filament\Clusters\Parameters\Resources\AccessLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessLog extends EditRecord
{
    protected static string $resource = AccessLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

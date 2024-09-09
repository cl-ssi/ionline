<?php

namespace App\Filament\Clusters\Parameters\Resources\HealthServiceResource\Pages;

use App\Filament\Clusters\Parameters\Resources\HealthServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHealthService extends EditRecord
{
    protected static string $resource = HealthServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

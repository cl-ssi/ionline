<?php

namespace App\Filament\Clusters\Parameters\Resources\HealthServiceResource\Pages;

use App\Filament\Clusters\Parameters\Resources\HealthServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHealthServices extends ListRecords
{
    protected static string $resource = HealthServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

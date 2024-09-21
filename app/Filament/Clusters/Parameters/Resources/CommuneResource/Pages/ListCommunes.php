<?php

namespace App\Filament\Clusters\Parameters\Resources\CommuneResource\Pages;

use App\Filament\Clusters\Parameters\Resources\CommuneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommunes extends ListRecords
{
    protected static string $resource = CommuneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

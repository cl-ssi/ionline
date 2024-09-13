<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ManualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManuals extends ListRecords
{
    protected static string $resource = ManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

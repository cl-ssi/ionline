<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\CountersampleDestructionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCountersampleDestructions extends ListRecords
{
    protected static string $resource = CountersampleDestructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

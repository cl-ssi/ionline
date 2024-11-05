<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcesses extends ListRecords
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

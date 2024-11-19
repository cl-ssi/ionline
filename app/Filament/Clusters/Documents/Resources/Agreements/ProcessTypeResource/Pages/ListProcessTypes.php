<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessTypeResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcessTypes extends ListRecords
{
    protected static string $resource = ProcessTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

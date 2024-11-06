<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourts extends ListRecords
{
    protected static string $resource = CourtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

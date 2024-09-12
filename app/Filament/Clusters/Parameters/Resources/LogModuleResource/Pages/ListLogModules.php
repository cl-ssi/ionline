<?php

namespace App\Filament\Clusters\Parameters\Resources\LogModuleResource\Pages;

use App\Filament\Clusters\Parameters\Resources\LogModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogModules extends ListRecords
{
    protected static string $resource = LogModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

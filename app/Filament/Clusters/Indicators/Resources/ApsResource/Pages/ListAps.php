<?php

namespace App\Filament\Clusters\Indicators\Resources\ApsResource\Pages;

use App\Filament\Clusters\Indicators\Resources\ApsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAps extends ListRecords
{
    protected static string $resource = ApsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

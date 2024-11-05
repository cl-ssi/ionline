<?php

namespace App\Filament\Clusters\Drugs\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Drugs\Resources\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceptions extends ListRecords
{
    protected static string $resource = ReceptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

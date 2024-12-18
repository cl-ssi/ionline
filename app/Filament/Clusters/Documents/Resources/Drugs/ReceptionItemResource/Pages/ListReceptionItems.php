<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\ReceptionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceptionItems extends ListRecords
{
    protected static string $resource = ReceptionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

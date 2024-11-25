<?php

namespace App\Filament\Clusters\Finance\Resources\AccountancyResource\Pages;

use App\Filament\Clusters\Finance\Resources\AccountancyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountancies extends ListRecords
{
    protected static string $resource = AccountancyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

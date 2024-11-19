<?php

namespace App\Filament\Clusters\Finance\Resources\RequestFormResource\Pages;

use App\Filament\Clusters\Finance\Resources\RequestFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRequestForms extends ListRecords
{
    protected static string $resource = RequestFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

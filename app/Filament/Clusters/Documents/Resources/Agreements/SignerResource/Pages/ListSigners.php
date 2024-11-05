<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\SignerResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\SignerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSigners extends ListRecords
{
    protected static string $resource = SignerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

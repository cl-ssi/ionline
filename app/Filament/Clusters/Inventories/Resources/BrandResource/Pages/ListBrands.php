<?php

namespace App\Filament\Clusters\Inventories\Resources\BrandResource\Pages;

use App\Filament\Clusters\Inventories\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

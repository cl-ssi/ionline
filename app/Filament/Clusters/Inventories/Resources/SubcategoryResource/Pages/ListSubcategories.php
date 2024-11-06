<?php

namespace App\Filament\Clusters\Inventories\Resources\SubcategoryResource\Pages;

use App\Filament\Clusters\Inventories\Resources\SubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubcategories extends ListRecords
{
    protected static string $resource = SubcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

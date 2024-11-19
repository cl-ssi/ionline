<?php

namespace App\Filament\Clusters\Inventories\Resources\BrandResource\Pages;

use App\Filament\Clusters\Inventories\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

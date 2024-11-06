<?php

namespace App\Filament\Clusters\Inventories\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Inventories\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}

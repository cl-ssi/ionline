<?php

namespace App\Filament\Clusters\Documents\Resources\DocumentResource\Pages;

use App\Filament\Clusters\Documents\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;
}

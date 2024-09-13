<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ManualResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManual extends CreateRecord
{
    protected static string $resource = ManualResource::class;
}

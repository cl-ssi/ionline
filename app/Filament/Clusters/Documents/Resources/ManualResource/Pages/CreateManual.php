<?php

namespace App\Filament\Clusters\Documents\Resources\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\ManualResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManual extends CreateRecord
{
    protected static string $resource = ManualResource::class;
}

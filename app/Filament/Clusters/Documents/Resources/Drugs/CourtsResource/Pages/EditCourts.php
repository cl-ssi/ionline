<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\CourtsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourts extends EditRecord
{
    protected static string $resource = CourtsResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

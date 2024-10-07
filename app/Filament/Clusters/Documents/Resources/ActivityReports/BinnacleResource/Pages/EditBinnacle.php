<?php

namespace App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource\Pages;

use App\Filament\Clusters\Documents\Resources\ActivityReports\BinnacleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBinnacle extends EditRecord
{
    protected static string $resource = BinnacleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

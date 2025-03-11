<?php

namespace App\Filament\Clusters\TalentManagement\Resources\TrainingResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainings extends ListRecords
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

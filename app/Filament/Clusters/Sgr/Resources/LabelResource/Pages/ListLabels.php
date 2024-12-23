<?php

namespace App\Filament\Clusters\Sgr\Resources\LabelResource\Pages;

use App\Filament\Clusters\Sgr\Resources\LabelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabels extends ListRecords
{
    protected static string $resource = LabelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Sgr\LabelResource\Pages;

use App\Filament\Resources\Sgr\LabelResource;
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

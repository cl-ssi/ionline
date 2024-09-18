<?php

namespace App\Filament\Clusters\Parameters\Resources\SegmentResource\Pages;

use App\Filament\Clusters\Parameters\Resources\SegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSegments extends ListRecords
{
    protected static string $resource = SegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
}

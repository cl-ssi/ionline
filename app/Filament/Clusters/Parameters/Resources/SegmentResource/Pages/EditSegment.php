<?php

namespace App\Filament\Clusters\Parameters\Resources\SegmentResource\Pages;

use App\Filament\Clusters\Parameters\Resources\SegmentResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use function PHPUnit\Framework\isNull;

class EditSegment extends EditRecord
{
    protected static string $resource = SegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}

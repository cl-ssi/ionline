<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\ProcessReportResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\ProcessReportResource;
use Filament\Resources\Pages\ListRecords;

class ListProcessesReport extends ListRecords
{
    protected static string $resource = ProcessReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}

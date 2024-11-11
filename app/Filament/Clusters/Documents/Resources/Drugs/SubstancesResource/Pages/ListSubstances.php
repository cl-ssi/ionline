<?php

namespace App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource\Pages;

use App\Filament\Clusters\Documents\Resources\Drugs\SubstancesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubstances extends ListRecords
{
    protected static string $resource = SubstancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('report_confiscated')
                ->label('Informe ISP')
                ->icon('heroicon-o-chart-bar')
                ->url(route('filament.intranet.documents.resources.drugs.substances.report-confiscated')),
        ];
    }
}

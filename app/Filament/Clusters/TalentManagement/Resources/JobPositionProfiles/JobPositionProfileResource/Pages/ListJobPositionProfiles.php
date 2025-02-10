<?php

namespace App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\JobPositionProfiles\JobPositionProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobPositionProfiles extends ListRecords
{
    protected static string $resource = JobPositionProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('report_by_organizational_unit')
            ->label('Reporte por U.O.')
            ->icon('heroicon-o-chart-bar')
            ->url(route('filament.intranet.talent-management.resources.job-position-profiles.job-position-profiles.report-by-organizational-unit')),
        ];
    }
}
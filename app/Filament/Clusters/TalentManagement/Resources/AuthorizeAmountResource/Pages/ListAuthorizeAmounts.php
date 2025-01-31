<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Widgets\StatsAuthorizeAmountOverview;

class ListAuthorizeAmounts extends ListRecords
{
    protected static string $resource = AuthorizeAmountResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsAuthorizeAmountOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

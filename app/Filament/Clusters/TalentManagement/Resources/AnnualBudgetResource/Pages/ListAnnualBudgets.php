<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnnualBudgets extends ListRecords
{
    protected static string $resource = AnnualBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\AnnualBudgetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnualBudget extends EditRecord
{
    protected static string $resource = AnnualBudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

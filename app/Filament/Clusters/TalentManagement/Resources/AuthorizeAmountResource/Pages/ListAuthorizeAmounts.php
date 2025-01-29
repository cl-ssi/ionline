<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthorizeAmounts extends ListRecords
{
    protected static string $resource = AuthorizeAmountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

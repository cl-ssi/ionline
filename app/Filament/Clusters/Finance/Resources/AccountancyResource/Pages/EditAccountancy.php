<?php

namespace App\Filament\Clusters\Finance\Resources\AccountancyResource\Pages;

use App\Filament\Clusters\Finance\Resources\AccountancyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountancy extends EditRecord
{
    protected static string $resource = AccountancyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

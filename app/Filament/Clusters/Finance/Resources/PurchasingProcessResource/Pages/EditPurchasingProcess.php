<?php

namespace App\Filament\Clusters\Finance\Resources\PurchasingProcessResource\Pages;

use App\Filament\Clusters\Finance\Resources\PurchasingProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasingProcess extends EditRecord
{
    protected static string $resource = PurchasingProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

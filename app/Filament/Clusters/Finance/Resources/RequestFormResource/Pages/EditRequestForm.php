<?php

namespace App\Filament\Clusters\Finance\Resources\RequestFormResource\Pages;

use App\Filament\Clusters\Finance\Resources\RequestFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestForm extends EditRecord
{
    protected static string $resource = RequestFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

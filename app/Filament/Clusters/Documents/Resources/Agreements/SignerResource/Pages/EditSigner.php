<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\SignerResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\SignerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSigner extends EditRecord
{
    protected static string $resource = SignerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

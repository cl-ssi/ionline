<?php

namespace App\Filament\Clusters\Documents\Resources\SignatureRequestResource\Pages;

use App\Filament\Clusters\Documents\Resources\SignatureRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSignatureRequest extends EditRecord
{
    protected static string $resource = SignatureRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

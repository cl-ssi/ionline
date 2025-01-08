<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

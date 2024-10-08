<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganizationalUnit extends ViewRecord
{
    protected static string $resource = OrganizationalUnitResource::class;

    protected function getActions(): array
    {
        return [];
    }
}

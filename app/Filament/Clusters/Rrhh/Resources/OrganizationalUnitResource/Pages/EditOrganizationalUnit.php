<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalUnit extends EditRecord
{
    protected static string $resource = OrganizationalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}

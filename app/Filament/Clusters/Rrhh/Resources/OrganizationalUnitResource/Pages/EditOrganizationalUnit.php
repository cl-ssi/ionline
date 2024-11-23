<?php

namespace App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OrganizationalUnitResource;
use App\Models\Rrhh\OrganizationalUnit;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationalUnit extends EditRecord
{
    protected static string $resource = OrganizationalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn (): bool => $this->getRecord()->users()->exists())
            // Actions\DeleteAction::make()
            //     ->before(function ($action): void {
            //         $record = $this->getRecord();

            //         if ($record->users()->exists()) {
            //             $action->failureNotificationTitle('No se puede eliminar');
            //             $action->failureNotificationMessage('La unidad organizacional tiene usuarios asociados.');
            //             $action->halt();
            //         }
            //     }),
        ];
    }

}

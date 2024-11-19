<?php

namespace App\Filament\Clusters\Rrhh\Resources\OvertimeRefundResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\OvertimeRefundResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOvertimeRefund extends EditRecord
{
    protected static string $resource = OvertimeRefundResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

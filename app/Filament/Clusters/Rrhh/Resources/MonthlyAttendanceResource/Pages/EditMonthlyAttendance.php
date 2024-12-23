<?php

namespace App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyAttendance extends EditRecord
{
    protected static string $resource = MonthlyAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}

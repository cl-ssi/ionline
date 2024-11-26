<?php

namespace App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\MonthlyAttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMonthlyAttendance extends CreateRecord
{
    protected static string $resource = MonthlyAttendanceResource::class;
}

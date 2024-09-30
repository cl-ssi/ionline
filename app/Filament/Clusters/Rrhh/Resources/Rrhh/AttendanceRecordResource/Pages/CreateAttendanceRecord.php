<?php

namespace App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AttendanceRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceRecord extends CreateRecord
{
    protected static string $resource = AttendanceRecordResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['establishment_id'] = auth()->user()->establishment_id;
    
        return $data;
    }
}

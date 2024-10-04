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
        // Reemplazado por el Observer
        $data['user_id'] = auth()->id();
        $data['establishment_id'] = auth()->user()->establishment_id;
        $data['record_at'] = now();
    
        return $data;

    }
}

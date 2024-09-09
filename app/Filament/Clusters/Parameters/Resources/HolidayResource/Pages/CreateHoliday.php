<?php

namespace App\Filament\Clusters\Parameters\Resources\HolidayResource\Pages;

use App\Filament\Clusters\Parameters\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
}

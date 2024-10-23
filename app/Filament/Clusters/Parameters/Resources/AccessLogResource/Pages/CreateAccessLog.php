<?php

namespace App\Filament\Clusters\Parameters\Resources\AccessLogResource\Pages;

use App\Filament\Clusters\Parameters\Resources\AccessLogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccessLog extends CreateRecord
{
    protected static string $resource = AccessLogResource::class;
}

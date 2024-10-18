<?php

namespace App\Filament\Clusters\Finance\Resources\ReceptionResource\Pages;

use App\Filament\Clusters\Finance\Resources\ReceptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateReception extends CreateRecord
{
    protected static string $resource = ReceptionResource::class;
}

<?php

namespace App\Filament\Clusters\Finance\Resources\AccountancyResource\Pages;

use App\Filament\Clusters\Finance\Resources\AccountancyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAccountancy extends CreateRecord
{
    protected static string $resource = AccountancyResource::class;
}

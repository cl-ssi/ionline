<?php

namespace App\Filament\Clusters\Documents\Resources\Agreements\SignerResource\Pages;

use App\Filament\Clusters\Documents\Resources\Agreements\SignerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSigner extends CreateRecord
{
    protected static string $resource = SignerResource::class;
}

<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommitment extends CreateRecord
{
    protected static string $resource = CommitmentResource::class;
}

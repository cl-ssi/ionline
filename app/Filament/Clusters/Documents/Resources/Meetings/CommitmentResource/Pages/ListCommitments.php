<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommitments extends ListRecords
{
    protected static string $resource = CommitmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

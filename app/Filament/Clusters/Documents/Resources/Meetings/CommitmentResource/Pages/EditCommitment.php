<?php

namespace App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource\Pages;

use App\Filament\Clusters\Documents\Resources\Meetings\CommitmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommitment extends EditRecord
{
    protected static string $resource = CommitmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

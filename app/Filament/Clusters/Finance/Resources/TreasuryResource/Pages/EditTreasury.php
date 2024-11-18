<?php

namespace App\Filament\Clusters\Finance\Resources\TreasuryResource\Pages;

use App\Filament\Clusters\Finance\Resources\TreasuryResource;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;

class EditTreasury extends EditRecord
{
    protected static string $resource = TreasuryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        // TODO: set stored the files
    
        return $record;
    }
}

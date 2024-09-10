<?php

namespace App\Filament\Clusters\Parameters\Resources\NewsResource\Pages;

use App\Filament\Clusters\Parameters\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('deleteImage')
                ->label('Borrar imágen')
                ->action(function () {
                    $record = $this->record;
                    if (Storage::exists($record->image)) {
                        Storage::delete($record->image);
                    }
                    $record->image = null;
                    $record->save();
                })
                ->requiresConfirmation()
                ->color('danger')
                ->icon('heroicon-o-trash'),
            Actions\DeleteAction::make(),
        ];
    }
}

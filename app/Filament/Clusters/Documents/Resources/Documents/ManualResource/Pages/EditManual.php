<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ManualResource;
use App\Models\Documents\Manual;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManual extends EditRecord
{
    protected static string $resource = ManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('view')
                ->label('Ver')
                ->action(function (Manual $record) {
                    return redirect()->route('documents.manuals.show', $record->id);
                })
                ->icon('heroicon-o-eye')
                ->openUrlInNewTab(),
            ];
    }
}

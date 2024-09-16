<?php

namespace App\Filament\Clusters\Documents\Resources\Documents\ManualResource\Pages;

use App\Filament\Clusters\Documents\Resources\Documents\ManualResource;
use App\Models\Documents\Manual;
use Filament\Actions;
use Filament\Notifications\Notification;
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
            Actions\Action::make('approve')
                ->label('Enviar a aprobación')
                ->action(function (Manual $record) {
                    $record->createApproval();
                    Notification::make()
                        ->title('Manual enviado a aprobación')
                        ->success()
                        ->send();
                })
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->color('success')
                ->visible(fn (Manual $record): bool => ! $record->approval),
            Actions\Action::make('deleteApproval')
                ->label('Eliminar aprobación de '.$this->record->approval->id)
                ->action(function (Manual $record) {
                    if ($record->approval) {
                        $record->approval->delete();
                        Notification::make()
                            ->title('Aprobación eliminada')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('No hay aprobacion para eliminar')
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-x-circle')
                ->requiresConfirmation()
                ->color('danger')
                ->visible(fn (Manual $record): bool => $record->approval && $record->approval->status == true),
        ];

    }
}

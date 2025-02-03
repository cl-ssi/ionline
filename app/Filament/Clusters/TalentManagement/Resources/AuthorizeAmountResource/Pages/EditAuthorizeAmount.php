<?php

namespace App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\AuthorizeAmountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAuthorizeAmount extends EditRecord
{
    protected static string $resource = AuthorizeAmountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Guardar Monto Autorizado')
                ->action(function () {
                    $this->save();

                    Notification::make()
                        ->title('Planificación Guardada')
                        ->success()
                        ->body('La información gue guardada con éxito.')
                        ->send();
                    
                    return;
                }),
                // ->visible(fn () => $this->record->authorize_amount == null && !in_array($this->record['status'], ['rejected', 'completed'])), // Permite cuando el estado es Guardado o Rechazado
            Actions\Action::make('cancelar')
                ->label('Cancelar')
                ->color('gray')
                ->url(fn () => route('filament.intranet.talent-management.resources.authorize-amounts.index')), // Redirige al índice
        ];
    }
}

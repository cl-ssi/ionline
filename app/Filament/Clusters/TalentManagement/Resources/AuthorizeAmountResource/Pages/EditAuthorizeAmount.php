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
            Actions\Action::make('save_authorize_amount')
                ->label('Guardar Monto Autorizado')
                ->action(function () {
                    if($this->record->status_value == 'Pendiente' && $this->record->authorize_amount == null){
                        // Monto Autorizado
                        $this->record->authorize_amount = $this->data['authorize_amount'];
                        $this->save();
                    }
                    else{
                        Notification::make()
                            ->title('Error')
                            ->danger()
                            ->body('Monto autorizado ya fue ingresado anteriormente.')
                            ->send();
                        return;
                    }
                })
                ->visible(fn () => $this->record->authorize_amount == null), // Permite cuando el estado es Guardado o Rechazado
            Actions\Action::make('cancelar')
                ->label('Cancelar')
                ->color('gray')
                ->url(fn () => route('filament.intranet.talent-management.resources.authorize-amounts.index')), // Redirige al índice
        ];
    }
}

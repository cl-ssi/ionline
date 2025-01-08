<?php

namespace App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditIdentifyNeed extends EditRecord
{
    protected static string $resource = IdentifyNeedResource::class;

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
                ->label('Guardar cambios')
                ->action(function () {
                    // Validación en el backend
                    if ($this->record->status_value !== 'Guardado') {
                        abort(403, 'No tienes permiso para guardar este formulario.');
                    }

                    // Guardar cambios en el registro
                    $this->record->save();

                    // Mostrar notificación
                    Notification::make()
                        ->title('Cambios guardados')
                        ->success()
                        ->body('Los cambios han sido guardados exitosamente.')
                        ->send();
                })
                ->visible(fn () => $this->record->status_value === 'Guardado'), // Solo visible si el estado es 'Guardado',
            Actions\Action::make('cancelar')
                ->label('Cancelar')
                ->color('gray')
                ->url(fn () => route('filament.intranet.talent-management.resources.identify-needs.index')), // Redirige al índice
                // ilament.intranet.talent-management.resources.job-position-profiles.report-by-organizational-unit
            Actions\Action::make('enviar')
                ->label('Enviar')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function () {
                    if ($this->record->status_value !== 'Guardado') {
                        abort(403, 'No tienes permiso para enviar este formulario.');
                    }

                    $this->record->sendForm(); // Llama al método en el modelo
                    
                    // Mostrar notificación
                    Notification::make()
                        ->title('Formulario enviado')
                        ->success()
                        ->body('El formulario ha sido enviado exitosamente.')
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Confirmar Envío')
                ->modalSubheading('¿Está seguro de enviar a firmar este formulario?')
                ->modalButton('Confirmar')
                ->visible(fn () => $this->record->status_value === 'Guardado'), // Solo visible si el estado es 'Guardado'
        ];
    }
}

<?php

namespace App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource\Pages;

use App\Filament\Clusters\TalentManagement\Resources\IdentifyNeedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\User;

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
                    // CALCULAR EL TOTAL
                    $this->record->total_value = $this->data['coffee_break_price'] + $this->data['transport_price'] + $this->data['accommodation_price'] + $this->data['activity_value'];

                    // Guardar cambios en el registro
                    $this->record->status = 'saved';
                    $this->save();
                })
                ->visible(fn () => in_array($this->record->status_value, ['Guardado', 'Rechazado'])), // Permite cuando el estado es Guardado o Rechazado
            Actions\Action::make('cancelar')
                ->label('Cancelar')
                ->color('gray')
                ->url(fn () => route('filament.intranet.talent-management.resources.identify-needs.index')), // Redirige al índice
                // ilament.intranet.talent-management.resources.job-position-profiles.report-by-organizational-unit
            Actions\Action::make('enviar')
                ->label('Guardar y Enviar')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function () {
                    if (in_array($this->record->status_value, ['Pendiente','Finalizado'])) {
                        abort(403, 'No tienes permiso para enviar este formulario.');
                    }

                    // Verificar si hay al menos un AvailablePlace
                    if ($this->record->availablePlaces()->count() === 0) {
                        Notification::make()
                            ->title('Error')
                            ->danger()
                            ->body('Debe agregar al menos un Cupo por Estamento antes de enviar el formulario.')
                            ->send();
                        return;
                    }

                    // Guardar los cambios en la base de datos
                    $user = User::find($this->record->user_id);
                    $this->record->organizational_unit_id   = $user->organizational_unit_id;
                    $this->record->establishment_id         = $user->establishment_id;
                    $this->record->establishment_name       = $user->establishment->name;
                    $this->record->boss_id                  = $user->boss->id;
                    $this->record->boss_email               = $user->boss->email;

                    // CALCULAR EL TOTAL
                    $this->record->total_value              = $this->data['coffee_break_price'] + $this->data['transport_price'] + $this->data['accommodation_price'] + $this->data['activity_value'];
                    $this->save();

                    if($this->record->approvals){
                        $this->record->approvals()->delete();
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
                ->visible(fn () => in_array($this->record->status_value, ['Guardado', 'Rechazado'])), // Permite cuando el estado es Guardado o Rechazado
        ];
    }
}

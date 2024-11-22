<?php

namespace App\Filament\Clusters\Rrhh\Resources\UserResource\Pages;

use App\Filament\Clusters\Rrhh\Resources\UserResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
            Impersonate::make()->record($this->getRecord()),
            \Filament\Actions\Action::make('restaurar_clave')
                ->action(function (User $record){
                    $record->update(['password' => bcrypt($record->id)]);
                    Notification::make()
                        ->title('Clave reseteada: corresponde al run del usuario sin dv')
                        ->success()
                        ->send();
                })
        ];
    }
}

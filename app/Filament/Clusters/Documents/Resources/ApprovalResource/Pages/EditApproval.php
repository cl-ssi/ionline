<?php

namespace App\Filament\Clusters\Documents\Resources\ApprovalResource\Pages;

use App\Filament\Clusters\Documents\Resources\ApprovalResource;
use App\Models\Documents\Approval;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditApproval extends EditRecord
{
    protected static string $resource = ApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('resetStatus')
                ->label('Resetear Estado')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->action(function (Approval $record): void {
                    $record->resetStatus();
                    Notification::make()
                        ->title('Estado reseteado')
                        ->success()
                        ->send();
                }),
        ];
    }
}

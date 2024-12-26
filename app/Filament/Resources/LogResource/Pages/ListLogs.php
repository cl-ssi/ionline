<?php

namespace App\Filament\Resources\LogResource\Pages;

use App\Filament\Resources\LogResource;
use App\Models\Parameters\Log;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListLogs extends ListRecords
{
    protected static string $resource = LogResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            LogResource\Widgets\LogsByModuleChart::class,
            LogResource\Widgets\TopLogsByModuleWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('classifyAll')
                ->label('Classify All Logs')
                ->action(function () {
                    Log::where('created_at', '<', now()->subMonth())->delete();
                    Log::whereNull('module_id')->get()->each->classify();

                    // Enviar una notificación de éxito
                    Notification::make()
                        ->title('Clasificación completada')
                        ->body('Todos los logs han sido clasificados correctamente.')
                        ->success() // Define el tipo de notificación como "success"
                        ->send();
                }),
            Actions\Action::make('Send Database Notification')
                ->action(fn () => Notification::make()
                    ->icon('heroicon-o-document')
                    ->title('Title:Módulo')
                    ->body('Body:Subject')
                    ->actions([
                        Action::make('Ver')
                            ->button()
                            ->url(route('home'), shouldOpenInNewTab: true)
                            ->close(),
                        Action::make('marcarComoLeíada')
                            ->button()
                            ->color('secondary')
                            ->markAsRead(),
                    ])
                    ->sendToDatabase(auth()->user())
                ),
        ];
    }
}

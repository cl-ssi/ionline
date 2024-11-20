<?php

namespace App\Filament\Clusters\Parameters\Pages;

use App\Filament\Clusters\Parameters;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Filament\Notifications\Notification;

class TestUtilities extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Pruebas';

    protected static ?string $title = 'Pruebas del Sistema';

    protected static string $view = 'filament.clusters.parameters.pages.test-utilities';

    protected static ?string $cluster = Parameters::class;

    public function sendTestEmail(): void
    {
        try {
            Mail::raw('Este es un correo de prueba desde el sistema.', function ($message) {
                $message->to(auth()->user()->email)
                    ->subject('Correo de Prueba');
            });

            Notification::make()
                ->title('Correo de prueba enviado con éxito.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al enviar el correo: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function checkApiAvailability(): void
    {
        try {
            $response = Http::get('https://api.mercadopublico.cl/servicios/v2/publico/ordenesdecompra.json', [
                'codigo' => '1057448-38-SE24',
                'ticket' => env('TICKET_MERCADO_PUBLICO')
            ])->timeout(1);

            if ($response->successful()) {
                Notification::make()
                    ->title('La API está disponible.')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('La API respondió con un error: ' . $response->status())
                    ->warning()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al conectar con la API: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function testQueueProcessing(): void
    {
        try {
            Queue::push(function () {
                logger('Cola de prueba ejecutada con éxito.');
            });

            Notification::make()
                ->title('Cola enviada con éxito. Verifica los logs para confirmar su procesamiento.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error al enviar la tarea a la cola: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getActions(): array
    {
        return [
            \Filament\Pages\Actions\Action::make('sendTestEmail')
                ->label('Probar Envío de Email')
                ->action('sendTestEmail'),
            \Filament\Pages\Actions\Action::make('checkApiAvailability')
                ->label('Probar MercadoPublico')
                ->action('checkApiAvailability'),
            \Filament\Pages\Actions\Action::make('testQueueProcessing')
                ->label('Probar Colas')
                ->action('testQueueProcessing'),
        ];
    }
}

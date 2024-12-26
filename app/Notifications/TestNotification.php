<?php

namespace App\Notifications;

use App\Filament\Clusters\Rrhh\Resources\Rrhh\AbsenteeismResource\Pages\CreateAbsenteeism;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $param;

    /**
     * Pasos:
     * Crear una nueva $ php artisan make:notification Modulo/Notificación
     *
     * 1. (Opcional) En el constructor se pueden pasar parámetros
     * 2. Cambiar a 'database' en el método via
     * 3. En método toArray va la notificación
     *
     * Para utilizarlo:
     * $user->notify(new App\Notifications\TestNotification($param));
     *
     * Ej:
     * $user->notify(new App\Notifications\TestNotification(69));
     */

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->level('info')
            ->subject('Nueva notificación de prueba')
            ->line('Hola '.$notifiable->shortName)
            ->line('Notificación de prueba, parametro: '.$this->param)
            ->action('Notification Action', url('/'))
            ->line('Utilizando Colas')
            ->salutation('Saludos cordiales.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // return [
        //     'module'  => 'Prueba', // Opcional
        //     'icon'    => '<i class="fas fa-fw fa-bomb"></i>', // Opcional
        //     'subject' => 'Nueva notificación de prueba, parametro: '.$this->param,
        //     'action' => route('resources.computer.edit',[$this->param], false),
        // ];

        return [
            'title'   => 'Ausentismos', /* Modulo */
            'body'    => "Nuevo ausentismo de {$this->param}", /* Subject */
            'icon'    => 'bi-rocket', /* Icono de la notificación */
            // 'status'  => 'primary', /* Color del icono */
            'actions' => [
                [
                    'name'               => str_replace('\\', '_', get_class($this)), // una especie de pk para la notificación
                    'icon'               => 'heroicon-o-rocket-launch', /* Icono de la acción */
                    'label'              => 'Crear Ausentismo',
                    // 'color'              => 'danger', /* Color del icono y del texto */
                    'url'                => CreateAbsenteeism::getUrl(), /* Url de la acción */
                    'shouldOpenInNewTab' => true, // Abrir o no en una nueva tab
                    "view"=> "filament-actions::button-action", // Fijo
                    // "shouldClose"=> true, // Elimina la notificación al hacer clic
                    "shouldMarkAsRead"=> true, // Marcar como leída al hacer clic
                ],
            ],
            'format'   => 'filament', // Fijo
            'duration' => 'persistent', // Fijo
            "view" => "filament-notifications::notification", // Fijo
        ];
    }

    /**
     * Tinker:
     * User::find(15287582)->notify(new TestNotification('Alvaro Torres'))
     *
     *
     * $user = User::find(15287582)
     *
     * LARAVEL
     * $user->notify(new TestNotification('parametro'))
     *
     * FILAMENT
     * use Filament\Notifications\Notification;
     * Filament\Notifications\Notification::make()->title('Notificacion de filament')->sendToDatabase($user);
     */
}

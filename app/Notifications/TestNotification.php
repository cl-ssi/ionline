<?php

namespace App\Notifications;

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
     * 
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
        return ['mail'];
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
        return [
            'module'  => 'Prueba', // Opcional
            'icon'    => '<i class="fas fa-fw fa-bomb"></i>', // Opcional
            'subject' => 'Nueva notificación de prueba, parametro: '.$this->param,
            'action' => route('resources.computer.edit',[$this->param], false),
        ];
    }
}

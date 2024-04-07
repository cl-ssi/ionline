<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\User;

class TestMail extends Notification
{
    use Queueable;

    /**
     * PARA QUE SE EJECUTEN EN UNA COLA CUSTOMIZADA 
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    // public function viaQueues()
    // {
    //     return [
    //         'mail' => 'testing',
    //     ];
    // }


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

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
            ->level('success')
            ->subject('Correo de prueba')
            ->greeting('Hola ' . $notifiable->name)
            ->line('Probado el envío de correos')
            ->action('iOnline', route('home') )
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
            //
        ];
    }
}

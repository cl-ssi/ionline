<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
                    ->subject('INFORMA PRORROGA DE CONTRATACIÓN AÑO 2024 SST')
                    ->greeting('Hola ' . $this->user['nombre'])
                    // ->line('Thank you for using our application!')
                    ->level('info')
                    ->line('Junto con saludar cordialmente, la Subdirección de Gestión y Desarrollo de las Personas comunica que por disposición de la Autoridad se ha dispuesto la prórroga de su contratación para el año 2024.')
                    ->line('Para verificar el registro, puede acceder a la plataforma de autoatención -> Ciclo de vida laboral -> Relación de servicios, posteriormente actualizando la fecha de corte al 31 de diciembre del 2024.')
                    ->salutation('Atte.');
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

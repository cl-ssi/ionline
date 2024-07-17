<?php

namespace App\Notifications\ReplacementStaff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalsStatusReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pendingsCount)
    {
        $this->pendingsCount = $pendingsCount;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'module'  => 'Solicitudes de Contratatación', // Opcional
            'icon'    => '<i class="far fa-id-card"></i>',
            'subject' => 'Estimado Usuario, favor dirigirse al módulo Solicitudes de Aprobación <br>'.$this->pendingsCount.' solicitudes en espera',
            'action'  => route('documents.approvals', [], false)
        ];
    }
}

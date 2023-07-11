<?php

namespace App\Notifications\Amipass;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResponseDoubt extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        //
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
            //
            'module'  => 'Amipass Consulta', // Opcional
            'icon'    => '<i class="fas fa-question-circle"></i>', // Opcional
            'subject' => 'Han Respondido su Consulta/Sugerencia Amipass Nº: '.$this->param,
            'action' => route('welfare.amipass.question-show',[$this->param], false),
        ];
    }
}

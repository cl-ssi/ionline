<?php

namespace App\Notifications\Finance;

use Illuminate\Bus\Queueable;
use App\Models\Documents\Numeration;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Finance\Receptions\Reception;
use Illuminate\Notifications\Messages\MailMessage;

class NewReceptionSigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reception;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reception $reception, Numeration $numeration)
    {
        $this->reception = $reception;
        $this->numeration = $numeration;
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
            ->subject('Acta de Recepción Nº: ' . $this->reception->id)
            ->greeting('Hola ')
            ->line('Acta de Recepción Nº: ' . $this->reception->id)
            ->line('Creador: ' . $this->reception->user->shortName)
            ->action('Ver acta', route('documents.partes.numeration.show_numerated', $this->numeration->id) )
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

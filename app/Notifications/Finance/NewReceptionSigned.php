<?php

namespace App\Notifications\Finance;

use Illuminate\Bus\Queueable;
// use App\Models\Documents\Numeration; // No se si va o no
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Finance\Receptions\Reception;
use Illuminate\Notifications\Messages\MailMessage;

class NewReceptionSigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reception;

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'mail' => 'testing',
        ];
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reception $reception)
    {
        $this->reception = $reception;
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
            ->subject('Acta de Recepción Conforme Nº: ' . $this->reception->id)
            ->greeting('Informativo')
            ->line('Nueva Acta de Recepción Conforme Nº: ' . $this->reception->id)
            ->action('Acta Nº: '. $this->reception->id, route('documents.partes.numeration.show_numerated', $this->reception->numeration->id) )
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

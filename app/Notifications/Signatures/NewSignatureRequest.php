<?php

namespace App\Notifications\Signatures;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Documents\SignaturesFlow;

class NewSignatureRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $signaturesFlow;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SignaturesFlow $signaturesFlow)
    {
        $this->signaturesFlow = $signaturesFlow;
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
                    ->subject('Solicitud de firma: ' . $this->signaturesFlow->signature->subject)
                    ->greeting('Hola ' . $notifiable->shortName)
                    ->line('Se encuentra disponible un nuevo documento para su firma en iOnline.')
                    ->line('Número solicitud:  ' . $this->signaturesFlow->signature->id)
                    ->line('Tipo:  ' . $this->signaturesFlow->signature->type->name)
                    ->line('Asunto: ' . $this->signaturesFlow->signature->subject)
                    ->action('Solicitudes de firma', route('documents.signatures.index', 'pendientes'))
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

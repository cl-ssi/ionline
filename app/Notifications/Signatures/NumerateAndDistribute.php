<?php

namespace App\Notifications\Signatures;

use App\Models\Documents\Numeration;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Mail\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class NumerateAndDistribute extends Notification implements ShouldQueue
{
    use Queueable;

    public $numeration;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Numeration $numeration)
    {
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
        /**
         * Documento a distribuir
         */
        $document = Attachment::fromStorage($this->numeration->file_path)
            ->as('documento_' . $this->id . '.pdf')
            ->withMime('application/pdf');

        return (new MailMessage)
                    ->level('info')
                    ->subject('Documento: ' . $this->numeration->subject)
                    ->greeting('Hola '. $notifiable->shortName)
                    ->line('Adjunto encontrará el documento: ' . $this->numeration->subject)
                    ->line('Para su conocimiento y fines.')
                    ->line('Tipo: ' . $this->numeration->type->name)
                    ->line('Responsable: ' . $this->numeration->user->shortName)
                    ->salutation('Saludos cordiales.')
                    ->attach($document);
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

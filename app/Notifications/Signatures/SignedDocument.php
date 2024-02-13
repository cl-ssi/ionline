<?php

namespace App\Notifications\Signatures;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Mail\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Documents\Signature;

class SignedDocument extends Notification implements ShouldQueue
{
    use Queueable;

    protected $signature;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
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
        $email = new MailMessage();
        $email
            ->level('info')
            ->subject('Documento: ' . $this->signature->id . ' - ' . $this->signature->subject)
            ->greeting('Hola.')
            ->line('Adjunto encontrará el documento: ' . $this->signature->subject)
            ->line('Para su conocimiento y fines.')
            ->line('Tipo: ' . $this->signature->type->name)
            ->line('Creador: ' . $this->signature->responsable->shortName)
            ->salutation('Saludos cordiales.');
        
        /**
         * Documento principal
         */
        $document = Attachment::fromStorage($this->signature->signaturesFileDocument->signed_file)
            ->as('documento_' . $this->signature->id . '.pdf')
            ->withMime('application/pdf');

        $email->attach($document);

        /**
         * Anexos
         */
        foreach ($this->signature->signaturesFileAnexos as $key => $signaturesFileAnexo) {
            $anexo = Attachment::fromStorage($signaturesFileAnexo->file)
                ->as('anexo_' . $key . '.pdf')
                ->withMime('application/pdf');
            $email->attach($anexo);
        }

        return $email;
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

<?php

namespace App\Mail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Documents\Signature;

class SignedDocument extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $signature;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('My Subject')->html(
        //     (new MailMessage())
        //         ->line('The introduction to the notification.')
        //         ->action('Notification Action', url('/'))
        //         ->line('Thank you for using our application!')
        //         ->render(),
        // );

        $subject = "{$this->signature->type->name} - {$this->signature->subject}";
        $file = Storage::disk('gcs')->get($this->signature->signaturesFileDocument->signed_file);

        $email = $this->html(
            (new MailMessage())
                ->level('info')
                ->subject('Distribución de documento: ' . $this->signature->subject)
                ->greeting('Hola ')
                ->line('Adjunto encontrará el documento: ' . $this->signature->subject)
                ->line('Para su conocimiento y fines.')
                ->line('Tipo:  ' . $this->signature->type->name)
                ->line('Creador: ' . $this->signature->responsable->shortName)
                ->salutation('Saludos cordiales.')
                ->render(),
        )
            ->subject($subject)
            ->attachData($file, "documento.pdf", ['mime' => 'application/pdf']);

        foreach ($this->signature->signaturesFileAnexos as $key => $signaturesFileAnexo) {
            $email->attachFromStorageDisk('gcs', $signaturesFileAnexo->file, 'anexo_' . $key . '.pdf', ['mime' => 'application/pdf']);
        }

        return $email;
    }
}

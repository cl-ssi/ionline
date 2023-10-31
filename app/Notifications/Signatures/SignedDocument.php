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
        // $subject = "{$this->signature->type->name} - {$this->signature->subject}";
        // $file = Storage::disk('gcs')->get($this->signature->signaturesFileDocument->signed_file);

        // $email = $this->view('documents.signatures.mails.signed_notification_recipients')
        //     ->subject($subject)
        //     ->attachData($file,
        //         "{$this->signature->type->name}.pdf",
        //         ['mime' => 'application/pdf']);

        // foreach ($this->signature->signaturesFileAnexos as $key => $signaturesFileAnexo) {
        //     $email->attachFromStorageDisk('gcs', $signaturesFileAnexo->file, 'anexo_' . $key . '.pdf',
        //         ['mime' => 'application/pdf']);
        // }

        $attachment = Attachment::fromStorage($this->signature->signaturesFileDocument->signed_file)
            ->as($this->signature->id . '.pdf')
            ->withMime('application/pdf');

        return (new MailMessage)
                    ->level('info')
                    ->subject($this->signature->type->name . ' - ' . $this->signature->subject)
                    ->greeting('Junto con saludar cordialmente.')
                    ->line('Adjunto documento indicado para su conocimiento y fines.')
                    ->line('Tipo:  ' . $this->signature->type->name)
                    ->line('Asunto: ' . $this->signature->subject)
                    ->attach($attachment)
                    // ->action('Notification Action', url('/'))
                    ->salutation('Saludos cordiales.');

                    // ->level('info')
                    // ->subject('Requerimiento Nº: ' . $this->signature->id)
                    // ->greeting('Hola ' . $this->event->to_user->name)
                    // ->line('Nuevo requerimiento Nº: ' . $this->signature->id)
                    // ->line('Asunto: ' . $this->signature->subject)
                    // ->line('Detalle: ' . $this->event->body)
                    // ->line('Creador: ' . $this->signature->user->shortName)
                    // ->lineIf( !is_null($this->signature->user->organizational_unit_id), 'Unidad Organizacional: ' . $this->signature->user->organizationalUnit?->name)
                    // ->action('Ver Requerimiento (SGR) ' . $this->signature->id, route('requirements.show', $this->signature->id) )
                    // ->lineIf(!is_null($this->signature->limit_at),'Fecha límite: : '. $this->signature->limit_at)
                    // ->salutation('Saludos cordiales.');
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

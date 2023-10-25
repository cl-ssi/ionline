<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

use App\Models\ProfAgenda\OpenHour;

class OpenHourCancelation extends Mailable
{
    use Queueable, SerializesModels;

    public $openHour;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OpenHour $openHour)
    {
        $this->openHour = $openHour;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('', 'Servicio de Salud Tarapacá'),
            subject: 'Cancelación de reserva - Agenda UST',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'prof_agenda.mails.cancelation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

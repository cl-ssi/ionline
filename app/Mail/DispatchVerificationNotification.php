<?php

namespace App\Mail;


use App\Models\Pharmacies\Dispatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DispatchVerificationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $dispatch;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Dispatch $dispatch)
    {
        $this->dispatch = $dispatch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Nueva solicitud confirmación de recepción n°{$this->dispatch->id}";
        return $this->view('pharmacies.mails.dispatch_verification_notificacion')->subject($subject);
    }
}

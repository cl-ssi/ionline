<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;

class RequestFormSignNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $req;
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RequestForm $req, EventRequestForm $event)
    {
        $this->req = $req;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('request_form.mail.requestformsignnotification')
          ->subject('Formulario disponible para firma');
    }
}

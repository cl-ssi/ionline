<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\EventRequestForm;

class RfElectronicSignatureNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $req;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RequestForm $req)
    {
        $this->req = $req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('request_form.mail.rfelectronicsignaturenotification')
          ->subject('Formulario disponible para firma electrónica');
    }
}

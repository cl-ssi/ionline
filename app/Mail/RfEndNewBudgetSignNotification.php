<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestForms\RequestForm;

class RfEndNewBudgetSignNotification extends Mailable
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
        return $this->view('request_form.mail.rfendnewbudgetsignnotification')
          ->subject('Nuevo presupuesto aprobado para formulario de requerimiento');
    }
}

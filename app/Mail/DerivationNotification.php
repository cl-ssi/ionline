<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ServiceRequests\ServiceRequest;

class DerivationNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Order
     */
    public $cantidad;
    public $sender_name;
    public $receiver_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct($cantidad,$sender_name,$receiver_name)
    {
        $this->cantidad = $cantidad;
        $this->sender_name = $sender_name;
        $this->receiver_name = $receiver_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('service_requests/requests/mails/derivation')->subject("Se han derivado " . $this->cantidad . " solicitudes contratación de honorarios a su nombre.");
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RequestForms\RequestForm;

class RequestFormDirectorNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Order
     */
    public $notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct(RequestForm $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('request_form/mail/notification');
    }
}

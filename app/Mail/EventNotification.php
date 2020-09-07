<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ticket\Event;

class EventNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Order
     */
    public $eventNotification;

    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct(event $eventNotification)
    {
        $this->eventNotification = $eventNotification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('ticket/mails/eventNotification');
    }
}

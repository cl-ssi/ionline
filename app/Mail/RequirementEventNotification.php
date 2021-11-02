<?php

namespace App\Mail;

use App\Requirements\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequirementEventNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $requirementEvent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $requirementEvent)
    {
        $this->requirementEvent = $requirementEvent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "{$this->requirementEvent->requirement->status}: {$this->requirementEvent->requirement->subject}";
        return $this->view('requirements.mails.requirement_event_notification')
            ->subject($subject);
    }
}

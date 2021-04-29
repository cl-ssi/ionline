<?php

namespace App\Mail;

use App\Requirements\Requirement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequirementNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $requirement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Requirement $requirement)
    {
        $this->requirement = $requirement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Requerimiento N°{$this->requirement->id}: $this->subject";
        return $this->view('requirements.mails.requirement_notification')
            ->subject($subject);

    }
}

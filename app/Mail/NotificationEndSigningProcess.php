<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ReplacementStaff\RequestReplacementStaff;

class NotificationEndSigningProcess extends Mailable
{
    use Queueable, SerializesModels;

    public $requestReplacementStaff;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RequestReplacementStaff $requestReplacementStaff)
    {
        $this->requestReplacementStaff = $requestReplacementStaff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('replacement_staff.request.mail.notificationendsigningprocess')
          ->subject('Fin proceso de firmas');
    }
}

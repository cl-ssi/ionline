<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ReplacementStaff\ReplacementStaff;

class NewStaffNotificationUser extends Mailable
{
    use Queueable, SerializesModels;

    public $replacementStaff;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ReplacementStaff $replacementStaff)
    {
        $this->replacementStaff = $replacementStaff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('replacement_staff.mail.newstaffnotificationuser')
          ->subject('Registro Ingreso Staff SS Iquique');
    }
}

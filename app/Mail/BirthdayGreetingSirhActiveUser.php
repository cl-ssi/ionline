<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Rrhh\SirhActiveUser;
use App\Models\Rrhh\BirthdayEmailConfiguration;

class BirthdayGreetingSirhActiveUser extends Mailable
{
    use Queueable, SerializesModels;

    public $sirhActiveUser;
    public $birthdayEmailConfiguration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SirhActiveUser $sirhActiveUser)
    {
        $this->sirhActiveUser = $sirhActiveUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->birthdayEmailConfiguration = BirthdayEmailConfiguration::all()->last();
        return $this->view('rrhh.mails.birthday_greeting_sirh_active_user')->subject(BirthdayEmailConfiguration::all()->last()->subject);
    }
}

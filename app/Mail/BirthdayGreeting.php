<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Rrhh\BirthdayEmailConfiguration;

class BirthdayGreeting extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $birthdayEmailConfiguration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->birthdayEmailConfiguration = BirthdayEmailConfiguration::all()->last();
        return $this->view('rrhh.mails.birthday_greeting')->subject(BirthdayEmailConfiguration::all()->last()->subject);
    }
}

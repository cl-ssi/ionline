<?php

namespace App\Livewire\Parameters\Mail;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Notifications\TestMail;
use App\Jobs\TestJob;

class Test extends Component
{
    public $mailResponse;
    public $status;

    /**
    * SendMail
    */
    public function sendMail()
    {

        try {
            auth()->user()->notify(new TestMail());
            $this->mailResponse = "Correo envíado";
            $this->status = 'success';
        } catch (\Exception $exception) { //TransportException
            $this->mailResponse = $exception->getMessage();
            $this->status = 'danger';
        }
        // try {
        //     // Mail::to(auth()->user())
        //     //     ->send(new TestMail(auth()->user()));
        //     $this->mailResponse = "Correo envíado";
        //     $this->status = 'success';
        // } catch (\Exception $exception) {
        //     $this->mailResponse = $exception->getMessage();
        //     $this->status = 'danger';
        // }
    }

    public function render()
    {
        return view('livewire.parameters.mail.test');
    }
}

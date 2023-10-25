<?php

namespace App\Http\Livewire\Parameters\Mail;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
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
        dispatch(new TestJob(auth()->user()));

        // try {
        //     Mail::to(auth()->user())
        //         ->send(new TestMail(auth()->user()));
        //         // ->later(now()->addMinutes(5), new TestMail(auth()->user()));
        //         // ->queue(new TestMail(auth()->user()));
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

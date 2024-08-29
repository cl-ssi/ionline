<?php

namespace App\Livewire\Parameters\Notification;

use App\Jobs\TestJob;
use App\Notifications\TestNotification;
use Livewire\Component;

class Test extends Component
{
    public function sendNotification() {
        //auth()->user()->notify(new TestNotification(69));
        // ProcessApproval::dispatch($approval);
        TestJob::dispatch(auth()->user());
    }

    public function render()
    {
        return view('livewire.parameters.notification.test');
    }
}

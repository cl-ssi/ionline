<?php

namespace App\Http\Livewire\Parameters\Notification;

use App\Notifications\TestNotification;
use Livewire\Component;

class Test extends Component
{
    public function sendNotification() {
        auth()->user()->notify(new TestNotification(69));
    }

    public function render()
    {
        return view('livewire.parameters.notification.test');
    }
}

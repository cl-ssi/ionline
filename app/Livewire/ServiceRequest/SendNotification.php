<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Notifications\ServiceRequests\NewServiceRequest;

class SendNotification extends Component
{
    public $signatureFlow;
    public $notificationSent = false;

    public function sendNotification(){
        $email = $this->signatureFlow->user->email;
        $serviceRequest = $this->signatureFlow->serviceRequest;

        if ($this->signatureFlow->user && $this->signatureFlow->user->email != null) {
            if (filter_var($this->signatureFlow->user->email, FILTER_VALIDATE_EMAIL)) {
                $this->signatureFlow->user->notify(new NewServiceRequest($serviceRequest));
                // Marcar la notificación como enviada
                $this->notificationSent = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.service-request.send-notification');
    }
}

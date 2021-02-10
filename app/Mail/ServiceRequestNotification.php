<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ServiceRequests\ServiceRequest;

class ServiceRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Order
     */
    public $serviceRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('service_requests/requests/mails/new_service_request')->subject("Se ha creado la solicitud de contratación de honorarios nro. ".$serviceRequest->id);
    }
}

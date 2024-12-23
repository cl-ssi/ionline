<?php

namespace App\Mail;



use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestForms\RequestFormMessage;

class NewRequestFormMessage extends Mailable
{

use Queueable, SerializesModels;

    public $requestformmessage;

    public function __construct(RequestFormMessage $requestformmessage)
    {        
        $this->requestformmessage = $requestformmessage;
    }


    public function build()
    {        
        
        $subject = "Nuevo Mensaje para su Formulario de Requerimiento°{$this->requestformmessage->requestForm->id} digitado por el usuario {$this->requestformmessage->user->fullName}";
        return $this->view('request_form.mail.newrequestformmessage')
            ->subject($subject);

    }


    
}
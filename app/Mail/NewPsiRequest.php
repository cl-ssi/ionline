<?php

namespace App\Mail;


use App\Models\Suitability\PsiRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPsiRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $psirequest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PsiRequest $psirequest)
    {
        $this->psirequest = $psirequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$subject = "{$this->signaturesFlow->signature->document_type} - {$this->signaturesFlow->signature->subject}";
        $subject = "Nueva Solicitud de idoneidad n°{$this->psirequest->id} del {$this->psirequest->school->name}";
        return $this->view('suitability.mails.new_psi_request_notification')
            ->subject($subject);

    }
}

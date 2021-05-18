<?php

namespace App\Mail;

use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFlow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSignatureRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $signaturesFlow;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SignaturesFlow $signaturesFlow)
    {
        $this->signaturesFlow = $signaturesFlow;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "{$this->signaturesFlow->signature->document_type} - {$this->signaturesFlow->signature->subject}";
        return $this->view('documents.signatures.mails.new_signature_notification')
            ->subject($subject);

    }
}

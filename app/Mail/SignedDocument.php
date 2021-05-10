<?php

namespace App\Mail;

use App\Models\Documents\Signature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SignedDocument extends Mailable
{
    use Queueable, SerializesModels;

    public $signature;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "{$this->signature->document_type} - {$this->signature->subject}";
//        $file = Storage::disk('gcs')->get($this->signature->signaturesFileDocument->signed_file);
        $file = base64_decode($this->signature->signaturesFileDocument->signed_file);
        return $this->view('documents.signatures.mails.signed_notification_recipients')
            ->subject($subject)
            ->attachData($file,
                "{$this->signature->document_type}.pdf",
                ['mime' => 'application/pdf']);
    }
}

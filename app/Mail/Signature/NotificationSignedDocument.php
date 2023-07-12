<?php

namespace App\Mail\Signature;

use App\Models\Documents\Sign\Signature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotificationSignedDocument extends Mailable
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
        $subject = "{$this->signature->type->name} - {$this->signature->subject}";

        $file = Storage::disk('gcs')->get($this->signature->signed_file);

        $name = "{$this->signature->type->name}.pdf";

        $options = ['mime' => 'application/pdf'];

        $email = $this->view('documents.signatures.mails.signed_notification_recipients')
            ->subject($subject)
            ->attachData($file, $name, $options);

        return $email;
    }
}

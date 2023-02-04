<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Documents\Document;

class SendDocument extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * The order instance.
    *
    * @var Order
    */
    public $document;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file_name = 'SSI_'.$this->document->type->name.'_'.$this->document->number.'.pdf';
        $subject = $this->document->type->name.' N°:'.$this->document->number.': '.$this->document->subject;
        return $this->view('documents.mails.send')->subject($subject)
            ->attachFromStorageDisk('gcs',$this->document->file, $file_name, [
                                'mime' => 'application/pdf'
            ]);;
    }
}

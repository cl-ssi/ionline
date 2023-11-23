<?php

namespace App\Http\Livewire\Sign;

use Livewire\Component;
use App\Models\Documents\DigitalSignature;

class SignatureTest extends Component
{
    public $otp;
    public $message;
    public $type_message;

    /**
     * How to use
     *
     * @livewire('sign.signature-test')
     */

    public function render()
    {
        return view('livewire.sign.signature-test');
    }

    public function sign()
    {
        $this->message = null;

        $digitalSignature = new DigitalSignature(auth()->user(), 'signature');

        $files[] = public_path('samples/oficio.pdf');

        $signed = $digitalSignature->signature($files, $this->otp);

        if($signed) {
            $this->message = "La firma fue realizada exitosamente.";
            $this->type_message = 'success';
        }
        else {
            $this->message = $digitalSignature->error;
            $this->type_message = 'danger';
        }

        $this->otp = null;
    }
}

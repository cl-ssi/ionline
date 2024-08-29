<?php

namespace App\Livewire\Sign;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
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

        $files[] = Storage::get('ionline/samples/oficio.pdf');
        $positions[] = [];

        $digitalSignature = new DigitalSignature();
        $success = $digitalSignature->signature(auth()->user(), $this->otp, $files, $positions);

        if($success) {
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

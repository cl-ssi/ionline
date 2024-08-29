<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class MailSignature extends Component
{
    public $pronom;
    public $personalPhone;

    public function render()
    {
        return view('livewire.profile.mail-signature');
    }
}

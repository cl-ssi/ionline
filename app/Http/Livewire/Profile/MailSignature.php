<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class MailSignature extends Component
{
    public $pronom;
    public $personalPhone;

    public function render()
    {
        return view('livewire.profile.mail-signature')->extends('layouts.bt4.app');
    }
}

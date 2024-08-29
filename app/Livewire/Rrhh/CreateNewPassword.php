<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;

class CreateNewPassword extends Component
{
    public $newPassword;

    /**
    * Create new password
    */
    public function createPassword()
    {
        $this->newPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
        auth()->user()->password = bcrypt($this->newPassword);
        auth()->user()->password_changed_at = now();
        auth()->user()->save();
    }
    public function render()
    {
        return view('livewire.rrhh.create-new-password');
    }
}

<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\User;

class PersonalEmailInput extends Component
{
    public User $user;

    protected $rules = [
        'user.email_personal'  => 'required'
    ];

    /**
    * Enviar notificación de Confirmar email
    */
    public function sendEmailVerification()
    {
        $this->user->sendEmailVerificationNotification();
        session()->flash("info", "Solicitud de confirmación de email enviada");
    }

    public function render()
    {
        return view('livewire.rrhh.personal-email-input');
    }
}

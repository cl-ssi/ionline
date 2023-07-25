<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\User;
use App\Models\ClCommune;

class UserData extends Component
{
    public User $user;
    public $communes;

    protected $rules = [
        'user.name' => 'required|string|min:2',
        'user.fathers_family' => 'required|string|min:2',
        'user.mothers_family' => 'required|string|min:2',
        'user.address' => 'required|string|max:255',
        'user.commune_id' => 'required',
        'user.phone_number' => 'required|string|max:255',
        'user.email_personal' => 'required|string|max:255',
    ];

    /**
    * mount
    */
    public function mount()
    {
        $this->communes = ClCommune::pluck('name','id');
    }

    public function save() {
        $this->user->save();
        session()->flash("success", "Datos actualizados correctamente");
    }

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
        return view('livewire.service-request.user-data');
    }
}

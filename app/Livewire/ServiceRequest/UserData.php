<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\User;
use App\Models\ClCommune;
use App\Models\Country;

class UserData extends Component
{
    public User $user;
    public $communes;
    public $countries;

    protected $rules = [
        'user.name' => 'required|string|min:2',
        'user.fathers_family' => 'required|string|min:2',
        'user.mothers_family' => 'required|string|min:2',
        'user.address' => 'required|string|max:255',
        'user.commune_id' => 'required',
        'user.country_id' => 'required',
        'user.phone_number' => 'required|string|max:255',
        'user.email_personal' => 'required|string|max:255',
    ];

    /**
    * mount
    */
    public function mount()
    {
        $this->communes = ClCommune::pluck('name','id');
        $this->countries = Country::pluck('name','id');
    }

    public function save() {
        $this->user->save();
        session()->flash("user-data", "Datos actualizados correctamente");
    }

    /**
    * Enviar notificación de Confirmar email
    */
    public function sendEmailVerification()
    {
        $this->user->sendEmailVerificationNotification();
        session()->flash("user-data", "Solicitud de confirmación de email enviada");
    }

    public function render()
    {
        return view('livewire.service-request.user-data');
    }
}

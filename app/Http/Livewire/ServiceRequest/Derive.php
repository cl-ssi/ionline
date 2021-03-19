<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\User;

class Derive extends Component
{
    public $users;
    public $user_from_id;
    public $user_to_id;

    public $mensaje = "";

    public function derivar(){

        /* Acá va el código para derivar desde $user_form_id a $user_to_id */
        $this->mensaje = "Derivados";
    }

    public function render()
    {
        /* Mostrar sólo usuarios que tengan solicitudes para derivara para alivianar la vista */
        $this->users = User::orderBy('name','ASC')->get();
        return view('livewire.service-request.derive');
    }
}

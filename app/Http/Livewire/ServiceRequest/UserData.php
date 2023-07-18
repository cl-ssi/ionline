<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;
use App\User;

class UserData extends Component
{
    public User $user;
    
    public function render()
    {
        return view('livewire.service-request.user-data');
    }
}

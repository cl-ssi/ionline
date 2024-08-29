<?php

namespace App\Livewire\Rrhh;

use App\Models\User;
use Livewire\Component;

class UnverifyPersonalEmail extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function unverifyPersonalEmail()
    {
        $this->user->email_verified_at = null;
        $this->user->save();

        return redirect(route('rrhh.users.edit', ['user' => $this->user->id]));
    }

    public function render()
    {
        return view('livewire.rrhh.unverify-personal-email');
    }
}

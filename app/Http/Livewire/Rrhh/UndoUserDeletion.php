<?php

namespace App\Http\Livewire\Rrhh;

use App\User;
use Livewire\Component;

class UndoUserDeletion extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function undoUserDeletion()
    {
        $this->user->deleted_at = null;
        $this->user->save();

        return redirect(route('rrhh.users.index'))->with('success', 'Usuario: ' . $this->user->id . "-" . $this->user->dv . " Restaurado.");
    }

    public function render()
    {
        return view('livewire.rrhh.undo-user-deletion');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Doctrine\DBAL\Types\BigIntType;

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

        //return redirect(route('rrhh.users.index'));
    }

    public function render()
    {
        return view('livewire.undo-user-deletion');
    }
}

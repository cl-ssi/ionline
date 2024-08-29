<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class SetSinglePermission extends Component
{
    public User $user;
    public $permission;
    public $icon;

    /**
    * Set Permission 
    */
    public function setPermission()
    {
        if($this->user->can($this->permission)) {
            $this->user->revokePermissionTo($this->permission);
        }
        else {
            $this->user->givePermissionTo($this->permission);
        }
    }

    public function render()
    {
        return view('livewire.set-single-permission');
    }
}

<?php

namespace App\Http\Livewire\Rrhh;

use App\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsMgr extends Component
{
    public User $user;
    public $anterior = null;

    // metodo togglePermission
    public function togglePermission($permission)
    {
        if ($this->user->hasPermissionTo($permission)) {
            $this->user->revokePermissionTo($permission);
        } else {
            $this->user->givePermissionTo($permission);
        }
    }

    public function render()
    {
        $permissions = Permission::orderBy('name')->get();
        $userPermissions = $this->user->permissions->pluck('name')->toArray();

        return view('livewire.rrhh.permissions-mgr',
            [
                'permissions' => $permissions,
                'userPermissions' => $userPermissions,
            ]);
    }
}

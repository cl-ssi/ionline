<?php

namespace App\Livewire\Rrhh;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsMgr extends Component
{
    public User $user;
    public $anterior = null;

    // metodo togglePermission
    public function togglePermission($permission)
    {
        if ($this->user->hasDirectPermission($permission)) {
            $this->user->revokePermissionTo($permission);
        } else {
            $this->user->givePermissionTo($permission);
        }
    }

    public function render()
    {
        $userPermissions = $this->user->permissions->pluck('name')->toArray();
        $permissions = Permission::whereNotIn('name',['be god','dev'])->orderBy('name')->get();

        return view('livewire.rrhh.permissions-mgr',
            [
                'permissions' => $permissions,
                'userPermissions' => $userPermissions,
            ]);
    }
}

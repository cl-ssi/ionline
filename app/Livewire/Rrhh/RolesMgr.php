<?php

namespace App\Livewire\Rrhh;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesMgr extends Component
{
    public User $user;
    public $openPermissions = [];

    // metodo toggleRole
    public function toggleRole($role)
    {
        if ($this->user->hasRole($role)) {
            $this->user->removeRole($role);
        } else {
            $this->user->assignRole($role);
        }
    }

    // metodo togglePermission
    public function togglePermission($permission)
    {
        if ($this->user->hasDirectPermission($permission)) {
            $this->user->revokePermissionTo($permission);
        } else {
            $this->user->givePermissionTo($permission);
        }
    }

    public function mount()
    {
        // Inicializa todos los permisos como cerrados
        $roles = Role::all();
        foreach ($roles as $rol) {
            $this->openPermissions[$rol->id] = false;
        }
    }

    public function togglePermissions($roleId)
    {
        // Cambiar el estado de los permisos para mostrar/ocultar
        $this->openPermissions[$roleId] = !$this->openPermissions[$roleId];
    }

    public function render()
    {
        $userRoles = $this->user->roles->pluck('name')->toArray();
        $userPermissions = $this->user->permissions->pluck('name')->toArray();
        $roles = Role::with('permissions')->whereNot('name','god')->orderBy('name')->get();

        return view('livewire.rrhh.roles-mgr', [
            'roles' => $roles, 
            'userRoles' => $userRoles,
            'userPermissions' => $userPermissions,
        ]);
    }
}

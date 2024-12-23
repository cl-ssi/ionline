<?php

namespace App\Policies\Rrhh;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationalUnitPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->can('be god') ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrganizationalUnit $organizationalUnit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('OrganizationalUnits: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrganizationalUnit $organizationalUnit): bool
    {
        return $user->can('OrganizationalUnits: edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrganizationalUnit $organizationalUnit): bool
    {
        return $user->can('OrganizationalUnits: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrganizationalUnit $organizationalUnit): bool
    {
        return $user->can('OrganizationalUnits: delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrganizationalUnit $organizationalUnit): bool
    {
        return false;
    }
}

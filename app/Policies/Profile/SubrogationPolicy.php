<?php

namespace App\Policies\Profile;

use App\Models\Profile\Subrogation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubrogationPolicy
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
        return $user->can('Authorities: create');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subrogation $subrogation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Authorities: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subrogation $subrogation): bool
    {
        return $user->can('Authorities: create');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subrogation $subrogation): bool
    {
        return $user->can('Authorities: create');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subrogation $subrogation): bool
    {
        return $user->can('Authorities: create');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subrogation $subrogation): bool
    {
        return false;
    }
}

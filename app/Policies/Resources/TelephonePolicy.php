<?php

namespace App\Policies\Resources;

use App\Models\Resources\Telephone;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TelephonePolicy
{
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
    public function view(User $user, Telephone $telephone): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Resources: create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Telephone $telephone): bool
    {
        return $user->can('Resources: edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Telephone $telephone): bool
    {
        return $user->can('Resources: delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Telephone $telephone): bool
    {
        return $user->can('Resources: edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Telephone $telephone): bool
    {
        return true;
    }
}

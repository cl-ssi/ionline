<?php

namespace App\Policies\Parameters;

use App\Models\Parameters\Program;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProgramPolicy
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
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Program $Program): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Program $Program): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Program $Program): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Program $Program): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Program $Program): bool
    {
        return false;
    }
}
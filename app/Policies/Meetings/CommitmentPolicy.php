<?php

namespace App\Policies\Meetings;

use App\Models\Meetings\Commitment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommitmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canany(['Meetings: all meetings', 'be god']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Commitment $commitment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Commitment $commitment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Commitment $commitment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Commitment $commitment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Commitment $commitment): bool
    {
        return false;
    }
}

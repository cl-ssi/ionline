<?php

namespace App\Policies\Unspsc;

use App\Models\Unspsc\Segment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SegmentPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ( $user->can('be god') ) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Segment $segment): bool
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
    public function update(User $user, Segment $segment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Segment $segment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Segment $segment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Segment $segment): bool
    {
        return false;
    }
}

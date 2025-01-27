<?php

namespace App\Policies\IdentifyNeeds;

use App\Models\IdentifyNeeds\IdentifyNeed;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdentifyNeedPolicy
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
    public function view(User $user, IdentifyNeed $identifyNeed): bool
    {
        return true;
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
    public function update(User $user, IdentifyNeed $identifyNeed): bool
    {
        // return ($user->can('DNC: all') || $user->id === $identifyNeed->user_id);
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, IdentifyNeed $identifyNeed): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, IdentifyNeed $identifyNeed): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, IdentifyNeed $identifyNeed): bool
    {
        return false;
    }
}

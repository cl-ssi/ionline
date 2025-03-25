<?php

namespace App\Policies\IdentifyNeeds;

use App\Models\IdentifyNeeds\AuthorizeAmount;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuthorizeAmountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return ($user->can('DNC: authorize amount'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AuthorizeAmount $authorizeAmount): bool
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
    public function update(User $user, AuthorizeAmount $authorizeAmount): bool
    {
        return ($user->can('DNC: authorize amount'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AuthorizeAmount $authorizeAmount): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AuthorizeAmount $authorizeAmount): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AuthorizeAmount $authorizeAmount): bool
    {
        return false;
    }
}

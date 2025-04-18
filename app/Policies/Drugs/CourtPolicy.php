<?php

namespace App\Policies\Drugs;

use App\Models\Drugs\Court;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CourtPolicy
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
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Court $Court): bool
    {
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Court $Court): bool
    {
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Court $Court): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Court $Court): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Court $Court): bool
    {
        return false;
    }
}

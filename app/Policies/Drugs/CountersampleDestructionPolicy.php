<?php

namespace App\Policies\Drugs;

use App\Models\Drugs\CountersampleDestruction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CountersampleDestructionPolicy
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
    public function view(User $user, CountersampleDestruction $countersampleDestruction): bool
    {
        return false;
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
    public function update(User $user, CountersampleDestruction $countersampleDestruction): bool
    {
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CountersampleDestruction $countersampleDestruction): bool
    {
        return $user->can('Drugs: manage parameters');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CountersampleDestruction $countersampleDestruction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CountersampleDestruction $countersampleDestruction): bool
    {
        return false;
    }
}

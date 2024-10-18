<?php

namespace App\Policies\Finance\Receptions;

use App\Models\Finance\Receptions\Reception;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReceptionPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->can('be god')) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Receptions: user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reception $reception): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Receptions: user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reception $reception): bool
    {
        return $user->id == $reception->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reception $reception): bool
    {
        //TODO: programar la eliminación en el observer
        // Eliminar la numeracion, approvals e items
        return false;
        // return $user->id == $reception->creator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reception $reception): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reception $reception): bool
    {
        return false;
    }
}

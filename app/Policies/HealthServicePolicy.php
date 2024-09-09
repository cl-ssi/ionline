<?php

namespace App\Policies;

use App\Models\HealthService;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HealthServicePolicy
{
    /**
     * Perform pre-authorization checks.
     * For administrative purposes, the user with the 'be god' ability can do anything.
     * If null is returned, the authorization check will fall through to the policy method
     */
    public function before(User $user): ?bool
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HealthService $healthService): bool
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
    public function update(User $user, HealthService $healthService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HealthService $healthService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HealthService $healthService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HealthService $healthService): bool
    {
        return false;
    }
}

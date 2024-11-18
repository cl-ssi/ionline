<?php

namespace App\Policies\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPositionProfilePolicy
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
        return $user->can('Job Position Profile: report');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobPositionProfile $jobPositionProfile): bool
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
    public function update(User $user, JobPositionProfile $jobPositionProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobPositionProfile $jobPositionProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, JobPositionProfile $jobPositionProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, JobPositionProfile $jobPositionProfile): bool
    {
        return false;
    }
}

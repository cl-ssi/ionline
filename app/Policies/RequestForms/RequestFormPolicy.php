<?php

namespace App\Policies\RequestForms;

use App\Models\RequestForms\RequestForm;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestFormPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canany(['be god']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RequestForm $requestForm): bool
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
    public function update(User $user, RequestForm $requestForm): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequestForm $requestForm): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequestForm $requestForm): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequestForm $requestForm): bool
    {
        return false;
    }
}

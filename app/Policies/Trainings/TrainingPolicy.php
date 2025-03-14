<?php

namespace App\Policies\Trainings;

use App\Models\Trainings\Training;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrainingPolicy
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
    public function view(User $user, Training $training): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Training $training): bool
    {
        return ($user->can('Trainings: all') || $user->id === $training->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Training $training): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        return false;
    }
}

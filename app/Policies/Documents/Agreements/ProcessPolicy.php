<?php

namespace App\Policies\Documents\Agreements;

use App\Models\Documents\Agreements\Process;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProcessPolicy
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
        return $user->canAny([
            'Agreement: delete',
            'Agreement: view',
            'Agreement: manage municipalities and signers',
            'Agreement: edit',
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Process $process): bool
    {
        return $user->can('Agreement: view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canAny([
            'Agreement: create'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Process $process): bool
    {
        // can Agreement edit AND $user is in $process->program->referers
        return $user->can('Agreement: admin') || 
        ($user->can('Agreement: edit') && $process->program->referers->contains($user));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Process $process): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Process $process): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Process $process): bool
    {
        return false;
    }
}

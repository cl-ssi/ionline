<?php

namespace App\Policies\Documents\Agreements;

use App\Models\Documents\Agreements\Signer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SignerPolicy
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
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Signer $signer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Signer $signer): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Signer $signer): bool
    {
        return $user->can('Agreement: manage municipalities and signers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Signer $signer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Signer $signer): bool
    {
        return false;
    }
}

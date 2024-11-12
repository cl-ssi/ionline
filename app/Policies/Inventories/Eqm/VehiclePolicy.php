<?php

namespace App\Policies\Inventories\Eqm;

use App\Models\Inventories\Eqm\Vehicle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VehiclePolicy
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
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vehicle $vehicle): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        return $user->can('Equipment Maintenance: administrador');
    }
}

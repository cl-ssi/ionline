<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $this->assignEstablishment($user);
    }

    /**
     * Handle the User "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        $this->assignEstablishment($user);
    }

    /**
     * Método para asignar establishment_id basado en organizational_unit_id.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function assignEstablishment(User $user)
    {
        // Si no tiene un establishment_id y tiene un organizational_unit_id
        if (is_null($user->establishment_id) && !is_null($user->organizational_unit_id)) {
            // Obtener la unidad organizativa del usuario
            $organizationalUnit = OrganizationalUnit::find($user->organizational_unit_id);

            // Si la unidad organizativa tiene un establishment_id, asignarlo al usuario
            if ($organizationalUnit && $organizationalUnit->establishment_id) {
                $user->establishment_id = $organizationalUnit->establishment_id;
            }
        }
    }
}

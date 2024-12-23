<?php

namespace App\Observers\Rrhh;

use App\Models\Rrhh\OrganizationalUnit;

class OrganizationalUnitObserver
{
    /**
     * Handle the OrganizationalUnit "created" event.
     */
    public function created(OrganizationalUnit $organizationalUnit): void
    {
        OrganizationalUnit::reorderUnits($organizationalUnit->establishment_id);
    }

    /**
     * Handle the OrganizationalUnit "updated" event.
     */
    public function updated(OrganizationalUnit $organizationalUnit): void
    {
        OrganizationalUnit::reorderUnits($organizationalUnit->establishment_id);
    }

    /**
     * Handle the OrganizationalUnit "deleted" event.
     */
    public function deleted(OrganizationalUnit $organizationalUnit): void
    {
        //
    }

    /**
     * Handle the OrganizationalUnit "restored" event.
     */
    public function restored(OrganizationalUnit $organizationalUnit): void
    {
        //
    }

    /**
     * Handle the OrganizationalUnit "force deleted" event.
     */
    public function forceDeleted(OrganizationalUnit $organizationalUnit): void
    {
        //
    }
}

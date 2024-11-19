<?php

namespace App\Observers\Documents\Agreements;

use App\Models\Documents\Agreements\Cdp;

class CdpObserver
{
    /**
     * Handle the Cdp "creating" event.
     */
    public function creating(Cdp $cdp): void
    {
        $cdp->creator_id = auth()->id();
    }

    /**
     * Handle the Cdp "created" event.
     */
    public function created(Cdp $cdp): void
    {
        //
    }

    /**
     * Handle the Cdp "updated" event.
     */
    public function updated(Cdp $cdp): void
    {
        //
    }

    /**
     * Handle the Cdp "deleted" event.
     */
    public function deleted(Cdp $cdp): void
    {
        //
    }

    /**
     * Handle the Cdp "restored" event.
     */
    public function restored(Cdp $cdp): void
    {
        //
    }

    /**
     * Handle the Cdp "force deleted" event.
     */
    public function forceDeleted(Cdp $cdp): void
    {
        //
    }
}

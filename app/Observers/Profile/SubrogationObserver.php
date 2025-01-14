<?php

namespace App\Observers\Profile;

use App\Models\Profile\Subrogation;

class SubrogationObserver
{
    /**
     * Handle the Subrogation "creating" event.
     */
    public function creating(Subrogation $subrogation): void
    {
        // If subrogant_id is not set, set it to the user_id
        if (empty($subrogation->subrogant_id)) {
            $subrogation->subrogant_id = $subrogation->user_id;
        }
    }

    /**
     * Handle the Subrogation "created" event.
     */
    public function created(Subrogation $subrogation): void
    {
        //
    }

    /**
     * Handle the Subrogation "updated" event.
     */
    public function updated(Subrogation $subrogation): void
    {
        //
    }

    /**
     * Handle the Subrogation "deleted" event.
     */
    public function deleted(Subrogation $subrogation): void
    {
        //
    }

    /**
     * Handle the Subrogation "restored" event.
     */
    public function restored(Subrogation $subrogation): void
    {
        //
    }

    /**
     * Handle the Subrogation "force deleted" event.
     */
    public function forceDeleted(Subrogation $subrogation): void
    {
        //
    }
}

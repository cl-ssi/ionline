<?php

namespace App\Observers\Finance\Receptions;

use App\Models\Finance\Receptions\Reception;

class ReceptionObserver
{
    /**
     * Handle the Reception "created" event.
     */
    public function creating(Reception $reception): void
    {
        $reception->establishment_id = auth()->user()->establishment_id;
        $reception->creator_id       = auth()->id();
        $reception->creator_ou_id    = auth()->user()->organizational_unit_id;
    }

    /**
     * Handle the Reception "created" event.
     */
    public function created(Reception $reception): void
    {
        //
    }

    /**
     * Handle the Reception "updated" event.
     */
    public function updated(Reception $reception): void
    {
        //
    }

    /**
     * Handle the Reception "deleted" event.
     */
    public function deleted(Reception $reception): void
    {
        //
    }

    /**
     * Handle the Reception "restored" event.
     */
    public function restored(Reception $reception): void
    {
        //
    }

    /**
     * Handle the Reception "force deleted" event.
     */
    public function forceDeleted(Reception $reception): void
    {
        //
    }
}

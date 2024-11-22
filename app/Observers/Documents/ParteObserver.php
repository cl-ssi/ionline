<?php

namespace App\Observers\Documents;

use App\Models\Documents\Parte;

class ParteObserver
{
    /**
     * Handle the Parte "created" event.
     */
    public function creating(Parte $parte): void
    {
        $parte->establishment_id = auth()->user()->establishment_id;
        $parte->organizational_unit_id = auth()->user()->organizational_unit_id;
        $parte->user_id = auth()->user()->id;
        $parte->entered_at = now();
        $parte->setCorrelative();
    }

    /**
     * Handle the Parte "updated" event.
     */
    public function updated(Parte $parte): void
    {
        //
    }

    /**
     * Handle the Parte "deleted" event.
     */
    public function deleted(Parte $parte): void
    {
        //
    }

    /**
     * Handle the Parte "restored" event.
     */
    public function restored(Parte $parte): void
    {
        //
    }

    /**
     * Handle the Parte "force deleted" event.
     */
    public function forceDeleted(Parte $parte): void
    {
        //
    }
}

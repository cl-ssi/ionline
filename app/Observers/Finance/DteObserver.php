<?php

namespace App\Observers\Finance;

use App\Models\Finance\Dte;

class DteObserver
{
    /**
     * Handle the Dte "created" event.
     */
    public function created(Dte $dte): void
    {
        // $dte->treasury()->create([
        //     'name' => $dte->folio,
        // ]);
    }

    /**
     * Handle the Dte "updated" event.
     */
    public function updated(Dte $dte): void
    {
        //
    }

    /**
     * Handle the Dte "deleting" event.
     */
    public function deleting(Dte $dte): void
    {
        // $dte->treasury()->delete();
    }

    /**
     * Handle the Dte "restored" event.
     */
    public function restored(Dte $dte): void
    {
        //
    }

    /**
     * Handle the Dte "force deleted" event.
     */
    public function forceDeleted(Dte $dte): void
    {
        //
    }
}

<?php

namespace App\Observers\Drugs;

use App\Models\Drugs\Protocol;

class ProtocolObserver
{
    /**
     * Handle the Protocol "created" event.
     */
    
    public function created(Protocol $protocol): void
    {
        if($protocol->result == 'Positivo' && $protocol->receptionItem->result_substance_id == null){
            $protocol->receptionItem->result_substance_id = $protocol->receptionItem->substance->result_id;
            $protocol->receptionItem->save();
        }
    }

    /**
     * Handle the Protocol "updated" event.
     */
    public function updated(Protocol $protocol): void
    {
        //
    }

    /**
     * Handle the Protocol "deleted" event.
     */
    public function deleted(Protocol $protocol): void
    {
        //
    }

    /**
     * Handle the Protocol "restored" event.
     */
    public function restored(Protocol $protocol): void
    {
        //
    }

    /**
     * Handle the Protocol "force deleted" event.
     */
    public function forceDeleted(Protocol $protocol): void
    {
        //
    }
}

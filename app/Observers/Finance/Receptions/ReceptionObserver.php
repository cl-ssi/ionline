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
        $ctApprovals = $reception->approvals->count();
        foreach($reception->approvals as $key => $approval) {
            /* Setear el reception_id que se obtiene despues de hacer el Reception::create();*/
            $approval->document_route_params = json_encode([
                "reception_id" => $reception->id
            ]);

            /* Setear el filename */
            $approval->filename = "ionline/finances/receptions/{$reception->id}.pdf";

            /* Si hay mas de un approval y no es el primero */
            if( $reception->approvals->count() >= 1 AND $key != 0 ) {
                /* Setea el previous_approval_id y active en false */
                $approval->previous_approval_id = $reception->approvals()->latest('id')->value('id');
                $approval->active = false;
            }

            /* Si es el último, entonces es el de firma electrónica */
            if (0 === --$ctApprovals) {
                $approval["digital_signature"] = true;
                $approval["callback_controller_method"] = 'App\Http\Controllers\Finance\Receptions\ReceptionController@approvalCallback';
            }
    
            $approval->save();
        }
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

<?php

namespace App\Observers\Documents\Agreements;

use App\Models\Documents\Agreements\Process;

class ProcessObserver
{
    /**
     * Handle the Process "creating" event.
     */
    public function creating(Process $process): void
    {
        $process->signer_appellative = $process->signer->appellative;
        $process->signer_decree = $process->signer->decree;
        $process->signer_name = $process->signer->user->full_name;

        $process->municipality_name = $process->municipality->name;
        $process->municipality_rut = $process->municipality->rut;
        $process->municipality_adress = $process->municipality->adress;

        $process->mayor_name = $process->mayor->name;
        $process->mayor_run = $process->mayor->run;
        $process->mayor_appelative = $process->mayor->appelative;
        $process->mayor_decree = $process->mayor->decree;

        $process->period = $process->program->period;
        $process->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Handle the Process "created" event.
     */
    public function created(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "updating" event.
     */
    public function updating(Process $process): void
    {
        $process->signer_appellative = $process->signer->appellative;
        $process->signer_decree = $process->signer->decree;
        $process->signer_name = $process->signer->user->full_name;

        $process->municipality_name = $process->municipality->name;
        $process->municipality_rut = $process->municipality->rut;
        $process->municipality_adress = $process->municipality->adress;

        $process->mayor_name = $process->mayor->name;
        $process->mayor_run = $process->mayor->run;
        $process->mayor_appelative = $process->mayor->appelative;
        $process->mayor_decree = $process->mayor->decree;
        $process->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Handle the Process "updated" event.
     */
    public function updated(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "deleted" event.
     */
    public function deleted(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "restored" event.
     */
    public function restored(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "force deleted" event.
     */
    public function forceDeleted(Process $process): void
    {
        //
    }
}

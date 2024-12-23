<?php

namespace App\Observers\Drugs;

use App\Models\Drugs\CountersampleDestruction;
use App\Models\Parameters\Parameter;

class CountersampleDestructionObserver
{
    /**
     * Handle the CountersampleDestruction "creating" event.
     */
    public function creating(CountersampleDestruction $receptionItem): void
    {
        $receptionItem->user_id = auth()->id();
        $manager_id = Parameter::get('drugs', 'Jefe', auth()->user()->organizationalUnit->establishment_id);
        $receptionItem->manager_id = $manager_id;
    }

    /**
     * Handle the CountersampleDestruction "created" event.
     */
    public function created(CountersampleDestruction $receptionItem): void
    {
        //
    }

    /**
     * Handle the CountersampleDestruction "updated" event.
     */
    public function updated(CountersampleDestruction $receptionItem): void
    {
        //
    }

    /**
     * Handle the CountersampleDestruction "deleted" event.
     */
    public function deleted(CountersampleDestruction $receptionItem): void
    {
        //
    }

    /**
     * Handle the CountersampleDestruction "restored" event.
     */
    public function restored(CountersampleDestruction $receptionItem): void
    {
        //
    }

    /**
     * Handle the CountersampleDestruction "force deleted" event.
     */
    public function forceDeleted(CountersampleDestruction $receptionItem): void
    {
        //
    }
}

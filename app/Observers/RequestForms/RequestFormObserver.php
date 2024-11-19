<?php

namespace App\Observers\RequestForms;

use App\Models\RequestForms\RequestForm;

class RequestFormObserver
{
    /**
     * Handle the RequestForm "creating" event.
     */
    public function creating(RequestForm $requestForm): void
    {
        $requestForm->establishment_id = $requestForm->contractManager->establishment_id;
    }

    /**
     * Handle the RequestForm "updating" event.
     */
    public function updating(RequestForm $requestForm): void
    {
        $requestForm->establishment_id = $requestForm->contractManager->establishment_id;
    }

    /**
     * Handle the RequestForm "deleted" event.
     */
    public function deleted(RequestForm $requestForm): void
    {
        //
    }

    /**
     * Handle the RequestForm "restored" event.
     */
    public function restored(RequestForm $requestForm): void
    {
        //
    }

    /**
     * Handle the RequestForm "force deleted" event.
     */
    public function forceDeleted(RequestForm $requestForm): void
    {
        //
    }
}

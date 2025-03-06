<?php

namespace App\Observers\Documents\Agreements;

use App\Models\Documents\Agreements\Certificate;

class CertificateObserver
{
    /**
     * Handle the Certificate "creating" event.
     */
    public function creating(Certificate $certificate): void
    {
        $certificate->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Handle the Certificate "updated" event.
     */
    public function updated(Certificate $certificate): void
    {
        //
    }

    /**
     * Handle the Certificate "deleted" event.
     */
    public function deleted(Certificate $certificate): void
    {
        // Borrar todos los apprvals
        $certificate->endorses()->delete();
    }

    /**
     * Handle the Certificate "restored" event.
     */
    public function restored(Certificate $certificate): void
    {
        //
    }

    /**
     * Handle the Certificate "force deleted" event.
     */
    public function forceDeleted(Certificate $certificate): void
    {
        //
    }
}

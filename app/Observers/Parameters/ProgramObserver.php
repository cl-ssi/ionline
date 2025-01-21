<?php

namespace App\Observers\Parameters;

use App\Models\Parameters\Program;

class ProgramObserver
{
    /**
     * Handle the Program "created" event.
     */
    public function created(Program $program): void
    {
        // Si tiene uno o ambos archivos entonces se actualizan los archivos de los approvals
        // de Process y Certificate
        if ($program->ministerial_resolution_file || $program->resource_distribution_file) {
            // por cada proceso y por cada certificado ejecutar la funcion createOrUpdateAttachmentsToApprovals
            foreach ($program->processes as $process) {
                $process->createOrUpdateAttachmentsToApprovals();
            }
            foreach ($program->certificates as $certificate) {
                $certificate->createOrUpdateAttachmentsToApprovals();
            }
        }
    }

    /**
     * Handle the Program "updated" event.
     */
    public function updated(Program $program): void
    {
        // lo mismo que el created, solo si es "dirty"
        if ($program->isDirty('ministerial_resolution_file') || $program->isDirty('resource_distribution_file')) {
            foreach ($program->processes as $process) {
                $process->createOrUpdateAttachmentsToApprovals();
            }
            foreach ($program->certificates as $certificate) {
                $certificate->createOrUpdateAttachmentsToApprovals();
            }
        }
    }

    /**
     * Handle the Program "deleted" event.
     */
    public function deleted(Program $program): void
    {
        //
    }

    /**
     * Handle the Program "restored" event.
     */
    public function restored(Program $program): void
    {
        //
    }

    /**
     * Handle the Program "force deleted" event.
     */
    public function forceDeleted(Program $program): void
    {
        //
    }
}

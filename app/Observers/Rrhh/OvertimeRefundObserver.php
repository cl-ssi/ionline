<?php

namespace App\Observers\Rrhh;

use App\Models\Rrhh\OvertimeRefund;

class OvertimeRefundObserver
{
    /**
     * Handle the OvertimeRefund "creating" event.
     */
    public function creating(OvertimeRefund $overtimeRefund): void
    {
        $overtimeRefund->user()->associate(auth()->user());
        $overtimeRefund->establishment()->associate(auth()->user()->establishment);
        $overtimeRefund->organizationalUnit()->associate(auth()->user()->organizationalUnit);
        $overtimeRefund->boss()->associate(auth()->user()->boss);
        $overtimeRefund->update(['boss_position', auth()->user()->boss_position]);
    }

    /**
     * Handle the OvertimeRefund "created" event.
     */
    public function created(OvertimeRefund $overtimeRefund): void
    {
        $overtimeRefund->createApprovals();
    }

    /**
     * Handle the OvertimeRefund "updated" event.
     */
    public function updated(OvertimeRefund $overtimeRefund): void
    {
        //
    }

    /**
     * Handle the OvertimeRefund "deleted" event.
     */
    public function deleted(OvertimeRefund $overtimeRefund): void
    {
        //delete approvals
        $overtimeRefund->approvals()->delete();
    }

    /**
     * Handle the OvertimeRefund "restored" event.
     */
    public function restored(OvertimeRefund $overtimeRefund): void
    {
        //
    }

    /**
     * Handle the OvertimeRefund "force deleted" event.
     */
    public function forceDeleted(OvertimeRefund $overtimeRefund): void
    {
        //
    }
}

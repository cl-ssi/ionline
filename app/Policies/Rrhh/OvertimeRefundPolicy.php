<?php

namespace App\Policies\Rrhh;

use App\Models\Rrhh\OvertimeRefund;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OvertimeRefundPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->can('be god') ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OvertimeRefund $overtimeRefund): bool
    {
        if( $user->canAny(['be god','Users: overtime refund admin']) OR $user->id === $overtimeRefund->user_id ) {
            return true;
        }
        $approvals = $overtimeRefund->approvals()->with(['sentToUser', 'sentToOu.manager'])->get();

        foreach ($approvals as $approval) {
            if (
                ($approval->sentToUser && $approval->sentToUser->id === $user->id) ||
                ($approval->sentToOu && $approval->sentToOu->manager && $approval->sentToOu->manager->id === $user->id)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OvertimeRefund $overtimeRefund): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OvertimeRefund $overtimeRefund): bool
    {
        // return $overtimeRefund->user_id == $user->id AND $overtimeRefund->status->value === 'pending';
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OvertimeRefund $overtimeRefund): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OvertimeRefund $overtimeRefund): bool
    {
        return false;
    }
}

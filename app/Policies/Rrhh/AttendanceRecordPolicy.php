<?php

namespace App\Policies\Rrhh;

use App\Models\Rrhh\AttendanceRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendanceRecordPolicy
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
        return $user->canAny(['Attendance records: user','Attendance records: admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AttendanceRecord $attendanceRecord): bool
    {
        return $user->id === $attendanceRecord->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Attendance records: user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AttendanceRecord $attendanceRecord): bool
    {
        return $user->id === $attendanceRecord->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AttendanceRecord $attendanceRecord): bool
    {
        // si el registro es mayor a 48 horas no se puede eliminar
        if ($attendanceRecord->record_at->diffInHours(now()) > 48) {
            return false;
        }

        return $user->id === $attendanceRecord->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AttendanceRecord $attendanceRecord): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AttendanceRecord $attendanceRecord): bool
    {
        return false;
    }
}

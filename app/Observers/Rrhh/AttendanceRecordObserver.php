<?php

namespace App\Observers\Rrhh;

use App\Models\Rrhh\AttendanceRecord;
use App\Notifications\Rrhh\NewAttendanceRecord;

class AttendanceRecordObserver
{
    // creating
    public function creating(AttendanceRecord $attendanceRecord): void
    {
        $attendanceRecord->user_id = auth()->id();
        $attendanceRecord->establishment_id = auth()->user()->establishment_id;
        $attendanceRecord->record_at = now();
    }

    /**
     * Handle the AttendanceRecord "created" event.
     */
    public function created(AttendanceRecord $attendanceRecord): void
    {
        if ($attendanceRecord->user && $attendanceRecord->user->boss && !empty($attendanceRecord->user->boss->email)) {
            $attendanceRecord->user->boss->notify(new NewAttendanceRecord($attendanceRecord));
        }
    }

    /**
     * Handle the AttendanceRecord "updated" event.
     */
    public function updated(AttendanceRecord $attendanceRecord): void
    {
        //
    }

    /**
     * Handle the AttendanceRecord "deleted" event.
     */
    public function deleted(AttendanceRecord $attendanceRecord): void
    {
        //
    }

    /**
     * Handle the AttendanceRecord "restored" event.
     */
    public function restored(AttendanceRecord $attendanceRecord): void
    {
        //
    }

    /**
     * Handle the AttendanceRecord "force deleted" event.
     */
    public function forceDeleted(AttendanceRecord $attendanceRecord): void
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Rrhh;

use Illuminate\Http\Request;
use App\Models\Rrhh\NoAttendanceRecord;
use App\Models\Documents\Approval;
use App\Http\Controllers\Controller;

class NoAttendanceRecordController extends Controller
{
    public function show(NoAttendanceRecord $noAttendanceRecord)
    {
        $documentFile = \PDF::loadView('rrhh.attendances.no-attendance-record', compact('noAttendanceRecord'));
        return $documentFile->stream();
    }

    /** Pocesa las aprobaciones del módulo approvals */
    public function approval($approval_id, $no_attendance_record_id)
    {
        $approval = Approval::find($approval_id);
        $noAttendanceRecord = NoAttendanceRecord::find($no_attendance_record_id);

        $noAttendanceRecord->authority_id = $approval->approver_id;
        $noAttendanceRecord->authority_at = $approval->approver_at;
        $noAttendanceRecord->authority_observation = $approval->reject_observation;
        $noAttendanceRecord->status = $approval->status;
        $noAttendanceRecord->save();
    }
}

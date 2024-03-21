<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\Rrhh\NoAttendanceRecord;
use App\Models\Documents\Approval;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NoAttendanceRecordController extends Controller
{
    /**
     * Retorna vista
     *
     * @param  int  $no_attendance_record_id
     * @return mixed
     */
    public function show($no_attendance_record_id)
    {
        $noAttendanceRecord = NoAttendanceRecord::find($no_attendance_record_id);
        $documentFile = \PDF::loadView('rrhh.attendances.no-attendance-record', compact('noAttendanceRecord'));

        return $documentFile->stream();
    }

    /**
     * Procesa las aprobaciones del módulo approvals
     *
     * @param  int  $approval_id
     * @param  int  $no_attendance_record_id
     * @return void
     */
    public function approval($approval_id, $no_attendance_record_id)
    {
        $approval = Approval::find($approval_id);
        $noAttendanceRecord = NoAttendanceRecord::find($no_attendance_record_id);

        $noAttendanceRecord->authority_id = $approval->approver_id;
        $noAttendanceRecord->authority_at = $approval->approver_at;
        $noAttendanceRecord->authority_observation = $approval->approver_observation;
        $noAttendanceRecord->status = $approval->status;
        $noAttendanceRecord->save();
    }

}

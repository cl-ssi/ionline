<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;

class NoAttendanceRecordConfirmation extends Component
{
    public NoAttendanceRecord $noAttendanceRecord;

    protected function rules()
    {
        return [
            'noAttendanceRecord.authority_observation' => 'string',
        ];
    }

    protected $messages = [
        'noAttendanceRecord.authority_observation.string' => 'La observación debe tener un string.',
    ];

    /**
    * confirmation
    */
    public function confirmation($status)
    {
        $this->noAttendanceRecord->status = $status;
        $this->noAttendanceRecord->authority_at = now();
        $this->noAttendanceRecord->save();

        /** Actualiza el approval */
        if($this->noAttendanceRecord->approval) {
            $this->noAttendanceRecord->approval->status             = $this->noAttendanceRecord->status;
            $this->noAttendanceRecord->approval->approver_id        = $this->noAttendanceRecord->authority_id;
            $this->noAttendanceRecord->approval->approver_at        = $this->noAttendanceRecord->authority_at;
            $this->noAttendanceRecord->approval->reject_observation = $this->noAttendanceRecord->authority_observation;
            $this->noAttendanceRecord->approval->save();
        }

    }
    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-confirmation')->extends('layouts.bt4.app');
    }
}

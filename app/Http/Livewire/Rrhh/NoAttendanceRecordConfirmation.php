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
    }
    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-confirmation');
    }
}

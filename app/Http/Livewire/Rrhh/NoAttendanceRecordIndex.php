<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;

class NoAttendanceRecordIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rejectForm;
    public $rrhh_observation;

    /**
    * Registrado por rrhh
    */
    public function setOk(NoAttendanceRecord $noAttendanceRecord)
    {
        $noAttendanceRecord->rrhh_user_id = auth()->id();
        $noAttendanceRecord->rrhh_at = now();
        $noAttendanceRecord->rrhh_status = 1;
        $noAttendanceRecord->save();
    }

    /**
    * Reject Form
    */
    public function reject(NoAttendanceRecord $noAttendanceRecord)
    {
        $this->rejectForm = $noAttendanceRecord->id;
    }

    /**
    * Close Reject Form
    */
    public function closeRejectForm()
    {
        $this->rejectForm = null;
    }

    /**
    * Save Reject Form
    */
    public function saveRejectForm(NoAttendanceRecord $noAttendanceRecord)
    {
        $noAttendanceRecord->rrhh_user_id = auth()->id();
        $noAttendanceRecord->rrhh_at = now();
        $noAttendanceRecord->rrhh_observation = $this->rrhh_observation;
        $noAttendanceRecord->rrhh_status = 0;
        $noAttendanceRecord->status = null;
        $noAttendanceRecord->save();
        $this->closeRejectForm();
    }
    
    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-index',[
            'records' => NoAttendanceRecord::whereNotNull('status')
                ->where('establishment_id',auth()->user()->organizationalUnit->establishment_id)
                ->latest()
                ->paginate(50),
        ]);
    }
}

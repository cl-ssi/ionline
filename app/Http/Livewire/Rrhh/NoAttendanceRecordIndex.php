<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;

class NoAttendanceRecordIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /**
    * Registrado por rrhh
    */
    public function setOk(NoAttendanceRecord $noAttendanceRecord)
    {
        $noAttendanceRecord->rrhh_user_id = auth()->id();
        $noAttendanceRecord->rrhh_at = now();
        $noAttendanceRecord->save();
    }
    
    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-index',[
            'records' => NoAttendanceRecord::whereNotNull('status')->latest()->paginate(50),
        ]);
    }
}

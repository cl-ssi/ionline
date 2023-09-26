<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;
use App\User; 

class NoAttendanceRecordIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rejectForm;
    public $rrhh_observation;
    public $filter = '';
    



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
        /** 
         * Ya no vamos a devolver las justificaciones de asistencia, se crearan nuevas
         * Por lo tanto el status queda en el estado que estaba 
         */
        // $noAttendanceRecord->status = null;
        $noAttendanceRecord->save();
        $this->closeRejectForm();
    }


    public function searchFuncionary()
    {
        $this->resetPage();
        $this->render();
    }



    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-index', [
            'records' => NoAttendanceRecord::whereNotNull('status')
                ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                ->when($this->filter, function ($query) {
                    $query->whereHas('user', function ($userQuery) {
                        $userQuery->findByUser($this->filter);
                    });
                })
                ->latest()
                ->paginate(50),
        ]);
    }
}

<?php

namespace App\Livewire\Rrhh;

use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NoAttendanceRecordsExport;

class NoAttendanceRecordIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rejectForm;
    public $rrhh_observation;
    public $name = '';
    public $from;
    public $to;
    public $rrhh_at;
    public $establishment_id;
    public $simplified = false;
    public $period = false;
    public $checkToOk = [];
    public $establishments;

    public function mount()
    {
        $this->establishments = Establishment::whereIn('id', explode(',', env('APP_SS_ESTABLISHMENTS')))->pluck('name', 'id');
        // Set establishemnt with estbalishment of the user
        $this->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Registrado por rrhh
     */
    public function setOk(NoAttendanceRecord $noAttendanceRecord)
    {
        $noAttendanceRecord->rrhh_user_id = auth()->id();
        $noAttendanceRecord->rrhh_at      = now();
        $noAttendanceRecord->rrhh_status  = 1;
        $noAttendanceRecord->save();
    }

    /**
     * Registrado por rrhh masivo
     */
    public function setOkMassive()
    {
        foreach ( $this->checkToOk as $setOk ) {
            $noAttendanceRecord = NoAttendanceRecord::find($setOk);
            $this->setOk($noAttendanceRecord);
        }
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
        $noAttendanceRecord->rrhh_user_id     = auth()->id();
        $noAttendanceRecord->rrhh_at          = now();
        $noAttendanceRecord->rrhh_observation = $this->rrhh_observation;
        $noAttendanceRecord->rrhh_status      = 0;
        /**
         * Ya no vamos a devolver las justificaciones de asistencia, se crearan nuevas
         * Por lo tanto el status queda en el estado que estaba
         */
        // $noAttendanceRecord->status = null;
        $noAttendanceRecord->save();
        $this->closeRejectForm();

        $this->period = false;
    }

    public function searchFuncionary()
    {
        if ( $this->from != null && $this->to != null ) {
            $this->period = true;
        }

        $this->resetPage();
        $this->render();

        $this->validate([
            'from' => [
                'nullable',
                'date',
                Rule::requiredIf(function () {
                    return !empty ($this->to);
                }),
            ],
            'to'   => [
                'nullable',
                'date',
                'after_or_equal:from',
            ],
        ]);

        $this->checkToOk = [];
    }


    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-index', [
            'records' => NoAttendanceRecord::with('authority', 'user', 'reason')
                ->whereNotNull('status')
                // ->whereIn('establishment_id', explode(',',$establishments_ids))
                ->when($this->name, function ($query) {
                    $query->whereHas('user', function ($userQuery) {
                        $userQuery->findByUser($this->name);
                    });
                })
                ->when($this->from, function ($query) {
                    $query->whereDate('date', '>=', $this->from);
                })
                ->when($this->to, function ($query) {
                    $query->whereDate('date', '<=', $this->to);
                })
                ->when($this->establishment_id, function ($query) {
                    $query->where('establishment_id', $this->establishment_id);
                })
                ->when($this->rrhh_at, function ($query) {
                    if ( $this->rrhh_at == 'Si' ) {
                        $query->whereNotNull('rrhh_at');
                    } else if ( $this->rrhh_at == 'No' ) {
                        $query->whereNull('rrhh_at');
                    }
                })
                ->latest()
                ->paginate(100),
        ]);
    }

    public function export()
    {
        $records = NoAttendanceRecord::with('user', 'reason')
            ->whereNotNull('status')
            ->where('status', 1)
            // ->whereIn('establishment_id', explode(',',$establishments_ids))
            ->when($this->name, function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->findByUser($this->name);
                });
            })
            ->when($this->from, function ($query) {
                $query->whereDate('date', '>=', $this->from);
            })
            ->when($this->to, function ($query) {
                $query->whereDate('date', '<=', $this->to);
            })
            ->when($this->establishment_id, function ($query) {
                $query->where('establishment_id', $this->establishment_id);
            })
            ->when($this->rrhh_at, function ($query) {
                if ( $this->rrhh_at == 'Si' ) {
                    $query->whereNotNull('rrhh_at');
                } elseif ( $this->rrhh_at == 'No' ) {
                    $query->whereNull('rrhh_at');
                }
            })
            ->latest()
            ->get();

        return Excel::download(new NoAttendanceRecordsExport($records), 'no_attendance_records.xlsx');
    }

}

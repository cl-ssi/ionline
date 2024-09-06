<?php

namespace App\Livewire\Rrhh;

use Livewire\WithPagination;
use Livewire\Component;
use App\Notifications\Rrhh\NewNoAttendanceRecord;
use App\Models\Rrhh\NoAttendanceRecord;
use App\Models\Rrhh\Attendance\Reason;

class NoAttendanceRecordMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $formActive = false;

    public $noAttendanceRecord;

    public $reasons;

    public $authority;
    public $checkAuthority = false;
    public $message;

    protected function rules()
    {
        return [
            'noAttendanceRecord.type' => 'required',
            'noAttendanceRecord.date' => 'required|date',
            'noAttendanceRecord.reason_id' => 'required',
            'noAttendanceRecord.observation' => 'nullable',
        ];
    }

    protected $messages = [
        'noAttendanceRecord.date.required' => 'La fecha es requerida.',
        'noAttendanceRecord.reason_id.required' => 'El motivo es requerido.',
    ];

    /**
    * mount
    */
    public function mount()
    {
        if(auth()->user()->boss) {
            $this->authority = auth()->user()->boss;
            $this->checkAuthority = true;
        }

        $this->reasons = Reason::all();
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->formActive = false;
    }

    public function showForm(NoAttendanceRecord $noAttendanceRecord)
    {
        $this->noAttendanceRecord = NoAttendanceRecord::firstOrNew([ 'id' => $noAttendanceRecord->id]);
        $this->formActive = true;
    }

    /**
    * Save cuando ya fue editada y rechazada por RRHH
    */
    public function saveAfterEdit()
    {
        $this->noAttendanceRecord->rrhh_status = null;
        $this->noAttendanceRecord->rrhh_user_id = null;
        $this->noAttendanceRecord->rrhh_at = null;
        $this->noAttendanceRecord->authority_at = null;
        $this->saveFirstTime();
    }

    public function saveFirstTime()
    {
        $this->validate();
        $this->noAttendanceRecord->user_id = auth()->id();
        $this->noAttendanceRecord->authority_id = $this->authority->id;
        $this->noAttendanceRecord->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        $this->noAttendanceRecord->save();

        if ( !$this->noAttendanceRecord->approval ) {
            $this->noAttendanceRecord->approval()->create([
                "module" => "Asistencia",
                "module_icon" => "fas fa-clock",
                "subject" => $this->noAttendanceRecord->date . ' : ' . $this->noAttendanceRecord->user->shortName . '<br>' . $this->noAttendanceRecord->reason->name . ': ' . $this->noAttendanceRecord->observation,
                "document_route_name" => "rrhh.attendance.no-records.show",
                "document_route_params" => json_encode([ "no_attendance_record_id" => $this->noAttendanceRecord->id]),
                /** enviado a la OU del jefe guardada en authority, y no la OU seteada en el user */
                // "sent_to_ou_id" => auth()->user()->organizationalUnit->currentManager->organizational_unit_id,
                "sent_to_ou_id" => auth()->user()->boss->organizational_unit_id,
                "callback_controller_method" => "App\Http\Controllers\Rrhh\NoAttendanceRecordController@approval",
                "callback_controller_params" => json_encode([
                    //'approval_id' => xxx  <= este parámetro se agregará automáticamente al comienzo
                    'no_attendance_record_id' => $this->noAttendanceRecord->id,
                ]),
            ]);
        }

        // $this->authority->notify(new NewNoAttendanceRecord($this->noAttendanceRecord));
        $this->index();
    }

    public function render()
    {

        $myRecords = NoAttendanceRecord::with('user','authority','reason')
            ->whereUserId(auth()->id())
            ->latest()
            ->paginate(25);

        $authorityRecrods = NoAttendanceRecord::with('user','authority','reason')
            ->whereAuthorityId(auth()->id())->latest()
            ->whereNull('rrhh_status')
            ->paginate(50);

        return view('livewire.rrhh.no-attendance-record-mgr',[
            'myRecords' => $myRecords,
            'authorityRecrods' => $authorityRecrods
        ]);
    }
}

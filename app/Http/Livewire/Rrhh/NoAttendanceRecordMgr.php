<?php

namespace App\Http\Livewire\Rrhh;

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
    public $form = false;

    public $noAttendanceRecord;

    public $reasons;

    public $authority;
    public $checkAuthority = false;
    public $message;

    protected function rules()
    {
        return [
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
        $this->form = false;
    }

    public function form(NoAttendanceRecord $noAttendanceRecord)
    {
        $this->noAttendanceRecord = NoAttendanceRecord::firstOrNew([ 'id' => $noAttendanceRecord->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->noAttendanceRecord->user_id = auth()->id();
        $this->noAttendanceRecord->authority_id = $this->authority->id;
        $this->noAttendanceRecord->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        $this->noAttendanceRecord->save();
        
        $this->authority->notify(new NewNoAttendanceRecord($this->noAttendanceRecord));
        $this->index();
    }

    public function render()
    {
        $myRecords = NoAttendanceRecord::with(['reason'])->whereUserId(auth()->id())->latest()->paginate(25);
        $authorityRecrods = NoAttendanceRecord::with(['reason'])->whereAuthorityId(auth()->id())->latest()->paginate(25);

        return view('livewire.rrhh.no-attendance-record-mgr',[
            'myRecords' => $myRecords,
            'authorityRecrods' => $authorityRecrods
        ]);
    }
}

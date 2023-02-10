<?php

namespace App\Http\Livewire\Lobby;

use Livewire\WithPagination;
use Livewire\Component;
use App\User;
use App\Models\Lobby\Meeting;
use App\Models\Lobby\Compromise;

class MeetingMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $meeting;
    public $compromises = [];
    public $participants = array();

    protected $listeners = [
        'userSelected',
        'addUser' => 'addParticipant'
    ];


    /**
     * mount
     */
    public function mount()
    {
    }

    protected function rules()
    {
        return [
            'meeting.responsible_id' => 'required',
            'meeting.petitioner' => 'required',
            'meeting.date' => 'required|date_format:Y-m-d',
            'meeting.start_at' => 'date_format:H:i',
            'meeting.end_at' => 'date_format:H:i|after:meeting.start_at',
            'meeting.mecanism' => 'required',
            'meeting.subject' => 'required',
            'meeting.exponents' => 'string',
            'meeting.details' => 'string',
        ];
    }

    protected $messages = [
        'meeting.petitioner.required' => 'El solicitante es requerido',
        'meeting.date.required' => 'La fecha desde es requerida',
    ];

    public function userSelected($userSelected)
    {
        $this->meeting->responsible_id = $userSelected;
    }

    public function addParticipant(User $user)
    {
        $this->participants[] = [
            'user_id' => $user->id,
            'name' => $user->shortName,
            'organizationalUnit' => $user->organizationalUnit->name,
            'position' => $user->position,
            'establishment' => $user->organizationalUnit->establishment->alias,
        ];
    }

    public function addCompromise()
    {
        $this->compromises[] = [
            'name' => '',
            'date' => '',
            'status' => '',
        ];
    }

    public function removeCompromise($index)
    {
        array_splice($this->compromises, $index, 1);
    }


    public function removeParticipant($key)
    {
        unset($this->participants[$key]);
        $this->participants = array_values($this->participants);
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(Meeting $meeting)
    {
        $this->meeting = Meeting::firstOrNew(['id' => $meeting->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->meeting->save();

        /** Guardar los participantes */
        foreach ($this->participants as $user) {
            $this->meeting->participants()->attach([
                'user_id' => $user['user_id']
            ]);
        }

        /** Guardar los compromisos */
        foreach ($this->compromises as $compromise) {
            $newCompromise = new Compromise;
            $newCompromise->meeting_id = $this->meeting->id;
            $newCompromise->name = $compromise['name'];
            $newCompromise->date = $compromise['date'];
            $newCompromise->status = $compromise['status'];
            $newCompromise->save();
        }        
        $this->compromises = [];
        $this->index();
    }

    public function delete(Meeting $meeting)
    {
        $meeting->delete();
    }

    public function render()
    {
        app('debugbar')->log($this->participants);
        $meetings = Meeting::latest()->paginate(25);
        return view('livewire.lobby.meeting-mgr', [
            'meetings' => $meetings
        ]);
    }
}

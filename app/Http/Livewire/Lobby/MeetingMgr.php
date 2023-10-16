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
    public $meeting_id;
    public $compromises = [];
    public $participants = [];

    public $responsable;
    public $responsable_id;

    public $filter = [];

    public $delete_compromises = [];

    public $userResponsible;
    public $addParticipant;
    


    protected $listeners = [
        'userSelected',
        //'addUser' => 'addParticipant',
        'addParticipant',
        'userResponsible'
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

    public function removeParticipant($key)
    {
        unset($this->participants[$key]);
        $this->participants = array_values($this->participants);
    }

    public function addCompromise()
    {
        $this->compromises[] = Compromise::make([
            'name' => '',
            'date' => '',
            'status' => ''
        ]);
    }

    public function removeCompromise($key)
    {
        unset($this->compromises[$key]);
        $this->compromises = array_values($this->compromises);
    }


    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(Meeting $meeting)
    {
        $this->meeting = Meeting::firstOrNew(['id' => $meeting->id]);
        $this->responsable = $this->meeting->responsible;        
        $this->compromises = $this->meeting->compromises->toArray();
        $this->participants = $meeting->participants->map(function ($participant) {
            return [
                'user_id' => $participant->id,
                'name' => $participant->shortName,
                'organizationalUnit' => $participant->organizationalUnit->name,
                'position' => $participant->position,
                'establishment' => $participant->organizationalUnit->establishment->alias,
            ];
        })->toArray();
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->meeting->responsible_id = $this->responsable_id;
        $this->meeting->save();

        /** Guardar los participantes */
        foreach ($this->participants as $user) {
            $existingParticipant = $this->meeting->participants()->where('user_id', $user['user_id'])->first();
            if (!$existingParticipant) {
                $this->meeting->participants()->attach([
                    'user_id' => $user['user_id']
                ]);
            }
        }

        //dd($this->meeting->responsible_id);

        /** Guardar los compromisos */
        $this->meeting->compromises()->delete();
        $this->meeting->compromises()->createMany($this->compromises);

        $this->participants = [];
        $this->compromises = [];
        $this->index();
    }

    public function delete(Meeting $meeting)
    {
        $meeting->compromises->delete();
        $meeting->delete();
    }

    public function render()
    {
        $meetings = Meeting::filter($this->filter)
            ->latest()
            ->paginate(25);

        return view('livewire.lobby.meeting-mgr', [
            'meetings' => $meetings
        ])->extends('layouts.bt4.app');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function userResponsible(User $user_responsible)
    {
        $this->responsable_id =  $user_responsible->id;
    }
}

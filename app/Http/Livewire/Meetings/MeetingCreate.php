<?php

namespace App\Http\Livewire\Meetings;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Meetings\Meeting;
use App\User;

class MeetingCreate extends Component
{
    public $date, $type, $subject, $mechanism, $start_at, $end_at;

    /* Meeting to edit */
    public $meetingToEdit;
    public $idMeeting;

    // Listeners
    public $searchedUser;
    protected $listeners = ['searchedUser'];

    public function render()
    {
        return view('livewire.meetings.meeting-create');
    }

    public function mount($meetingToEdit){
        if(!is_null($meetingToEdit)){
            $this->meetingToEdit = $meetingToEdit;
            $this->setMeeting();
        }
    }

    public function save(){
        // dd($this->date, $this->type, $this->subject, $this->mecanism, $this->start_at, $this->end_at);

        $meeting = DB::transaction(function () {
            $meeting = Meeting::updateOrCreate(
                [
                    'id'  =>  $this->idMeeting,
                ],
                [
                    'status'                => 'pending',
                    'user_creator_id'       => auth()->id(), 
                    'user_responsible_id'   => $this->searchedUser->id, 
                    'ou_responsible_id'     => $this->searchedUser->organizational_unit_id,
                    'establishment_id'      => $this->searchedUser->organizationalUnit->establishment_id,
                    'date'                  => $this->date,
                    'type'                  => $this->type,
                    'subject'               => $this->subject,
                    'mechanism'             => $this->mechanism,
                    'start_at'              => $this->start_at,
                    'end_at'                => $this->end_at
                ]
            );

            return $meeting;
        });

        if(is_null($this->meetingToEdit)){
            session()->flash('success', 'Estimados Usuario, se ha creado exitosamente la reunión');
        }
        // return redirect()->route('allowances.index');
        return redirect()->route('meetings.edit', [$meeting]);
    }

    /* Set Allowance */
    private function setMeeting(){

        if($this->meetingToEdit){
            $this->idMeeting    = $this->meetingToEdit->id;
            $this->searchedUser = $this->meetingToEdit->userResponsible;
            $this->date         = $this->meetingToEdit->date;
            $this->type         = $this->meetingToEdit->type;
            $this->subject      = $this->meetingToEdit->subject;
            $this->mechanism    = $this->meetingToEdit->mechanism;
            $this->start_at     = $this->meetingToEdit->start_at;
            $this->end_at       = $this->meetingToEdit->end_at;
        }
    }


    public function searchedUser(User $user){

        $this->searchedUser = $user;

        /*
        $this->userResponsibleId = $this->searchedUser->id;
        $this->position = $this->searchedUser->position;
        $this->telephone = ($this->searchedUser->telephones->count() > 0) ? $this->searchedUser->telephones->first()->minsal : '';
        $this->email = $this->searchedUser->email;

        $this->organizationalUnit = $this->searchedUser->organizationalUnit->name;
        */
    }
}

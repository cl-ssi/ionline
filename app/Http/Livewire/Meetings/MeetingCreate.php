<?php

namespace App\Http\Livewire\Meetings;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Meetings\Meeting;
use App\Models\Meetings\Grouping;
use App\Models\Meetings\Commitment;
use App\User;
use App\Rrhh\OrganizationalUnit;

class MeetingCreate extends Component
{
    public $date, $type, $subject, $mechanism, $start_at, $end_at;
    public $groupings, $typeGrouping, $nameGrouping;
    public $commitments, $commitmentDescription, $typeResponsible, $closingDate;

    /* Meeting to edit */
    public $meetingToEdit;
    public $idMeeting;

    // Listeners
    public $searchedUser, $searchedCommitmentUser, $searchedCommitmentOu;
    protected $listeners = ['searchedUser', 'searchedCommitmentUser', 'searchedCommitmentOu'];

    public function render()
    {
        return view('livewire.meetings.meeting-create');
    }

    public function mount($meetingToEdit){
        if(!is_null($meetingToEdit)){
            $this->meetingToEdit = $meetingToEdit;
            $this->setMeeting();
            $this->setGroupings();
            $this->setCommitments();
        }
    }

    public function save(){
        // SE GUARDA REUNIÓN
        $meeting = DB::transaction(function () {
            $meeting = Meeting::updateOrCreate(
                [
                    'id'  =>  $this->idMeeting,
                ],
                [
                    'status'                => 'pending',
                    'user_creator_id'       => auth()->id(), 
                    // 'user_responsible_id'   => $this->searchedUser->id, 
                    // 'ou_responsible_id'     => $this->searchedUser->organizational_unit_id,
                    'establishment_id'      => auth()->user()->organizationalUnit->establishment_id,
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

        //SE GUARDA GROUPING (Asociaciones / Federaciones / Reunión Mesas y Comités de Trabajos) PARTICIPANTES
        foreach($this->groupings as $grouping){
            Grouping::updateOrCreate(
                [
                    'id' => $grouping['id'] ? $grouping['id'] : null,
                ],
                [
                    'type'          => $grouping['type'], 
                    'name'          => $grouping['name'],
                    'meeting_id'    => $meeting->id
                ]
            );
        }

        //SE GUARDA COMPROMISOS
        foreach($this->commitments as $commitment){
            Commitment::updateOrCreate(
                [
                    'id' => $commitment['id'] ? $commitment['id'] : null,
                ],
                [
                    'description'           => $commitment['description'], 
                    'type'                  => $commitment['type'],
                    'commitment_user_id'    => $commitment['commitment_user_id'],
                    'commitment_ou_id'      => $commitment['commitment_ou_id'],
                    'closing_date'          => $commitment['closing_date'],
                    'meeting_id'            => $meeting->id,
                    'user_id'               => $commitment['user_id']
                ]
            );
        }

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
    }

    public function addGrouping(){
        // dd($this->typeGrouping, $this->nameGrouping);
        $this->groupings[] = [
            'id'            => '',
            'type'          => $this->typeGrouping,
            'name'          => $this->nameGrouping,
            'meeting_id'    => ($this->meetingToEdit) ? $this->meetingToEdit->id : null,
        ];
    }

    public function setGroupings(){
        if($this->meetingToEdit){
            foreach($this->meetingToEdit->groupings as $grouping){
            // foreach($this->groupings as $grouping){
                $this->groupings[] = [
                    'id'            => $grouping->id,
                    'type'          => $grouping->type,
                    'name'          => $grouping->name,
                    'meeting_id'    => $grouping->meeting_id
                ];
            }
        }
    }

    public function deleteGrouping($key){
        $itemToDelete = $this->groupings[$key];

        if($itemToDelete['id'] != ''){
            unset($this->groupings[$key]);
            $objectToDelete = Grouping::find($itemToDelete['id']);
            $objectToDelete->delete();
        }
        else{
            unset($this->groupings[$key]);
        }
    }

    public function addCommitment(){
        $this->commitments[] = [
            'id'                    => '',
            'description'           => $this->commitmentDescription,
            'type'                  => $this->typeResponsible,
            'commitment_user_id'    => ($this->typeResponsible == 'individual') ? $this->searchedCommitmentUser->id : null,
            'commitment_user_name'  => ($this->typeResponsible == 'individual') ? $this->searchedCommitmentUser->FullName : null,
            'commitment_ou_id'      => ($this->typeResponsible == 'ou') ? $this->searchedCommitmentOu->id : null,
            'commitment_ou_name'    => ($this->typeResponsible == 'ou') ? $this->searchedCommitmentOu->name : null,
            'closing_date'          => $this->closingDate,
            'requirement_id'        => '',
            'user_id'               => auth()->id()
        ];
    }

    public function setCommitments(){
        if($this->meetingToEdit){
            foreach($this->meetingToEdit->commitments as $commitment){
                $this->commitments[] = [
                    'id'                    => $commitment->id,
                    'description'           => $commitment->description,
                    'type'                  => $commitment->type,
                    'commitment_user_id'    => $commitment->commitment_user_id,
                    'commitment_user_name'  => ($commitment->commitment_user_id) ? $commitment->commitmentUser->FullName : null,
                    'commitment_ou_id'      => $commitment->commitment_ou_id,
                    'commitment_ou_name'    => ($commitment->commitment_ou_id) ? $commitment->commitmentOrganizationalUnit->name : null,
                    'closing_date'          => $commitment->closing_date,
                    'requirement_id'        => $commitment->requirement_id,
                    'user_id'               => $commitment->user_id
                ];
            }
        }
    }

    public function deleteCommitment($key){
        $itemToDelete = $this->commitments[$key];

        if($itemToDelete['id'] != ''){
            unset($this->commitments[$key]);
            $objectToDelete = Commitment::find($itemToDelete['id']);
            $objectToDelete->delete();
        }
        else{
            unset($this->commitments[$key]);
        }
    }

    public function searchedCommitmentUser(User $user){
        $this->searchedCommitmentUser = $user;
    }

    public function searchedCommitmentOu(OrganizationalUnit $organizationalUnit){
        $this->searchedCommitmentOu = $organizationalUnit;
    }
}

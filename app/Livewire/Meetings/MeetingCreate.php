<?php

namespace App\Livewire\Meetings;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Meetings\Meeting;
use App\Models\Meetings\Grouping;
use App\Models\Meetings\Commitment;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Rrhh\Authority;
use App\Models\Requirements\Requirement;
use App\Models\Requirements\Event;
use App\Notifications\Requirements\NewSgr;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MeetingCreate extends Component
{
    use WithFileUploads;

    public $form;
    
    public $date, $type, $description, $subject, $mechanism, $start_at, $end_at;
    public $groupings, $typeGrouping, $nameGrouping;
    public $commitments, $commitmentDescription, $typeResponsible, $priority, $closingDate;

    public $file, $iterationFileClean = 0;

    /* Meeting to edit */
    public $meetingToEdit;
    public $idMeeting;

    // Listeners
    public $searchedUser, $searchedCommitmentUser, $searchedCommitmentOu;

    public $groupingInput = null;

    protected function messages(){
        return [
            // MENSAJES PARA MEETING
            'date.required'         => 'Debe ingresar Fecha de reunión.',
            'type.required'         => 'Debe ingresar Tipo de reunión.',
            'subject.required'      => 'Debe ingresar Asunto de reunión.',
            'description.required'  => 'Debe ingresar Descripción de reunión.',
            'mechanism.required'    => 'Debe ingresar Medio de reunión.',
            'start_at.required'     => 'Debe ingresar Hora Inicio de reunión.',
            'end_at.required'       => 'Debe ingresar Hora de Fin de reunión.',
            // 'file.required'         => 'Debe ingresar un Adjunto',

            // MENSAJES PARA GROUPING
            'typeGrouping.required' => 'Debe ingresar Tipo de Asociaciones, Federaciones, etc.',
            'nameGrouping.required' => 'Debe ingresar Nombre de Asociaciones, Federaciones, etc.',
            'searchedUser.required' => 'Debe ingresar un funcionario.',

            // MENSAJES PARA COMMITMENT
            'commitmentDescription.required'    => 'Debe ingresar Descripción del compromiso',
            'typeResponsible.required'          => 'Debe ingresar Tipo de responsable del compromiso',
            'searchedCommitmentUser.required'   => 'Debe ingresar funcionario responsable del compromiso',
            'searchedCommitmentOu.required'     => 'Debe ingresar Unidad Organizacional responsable del compromiso',
            'priority.required'                 => 'Debe ingresar Prioridad del compromiso'
        ];
    }

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
        $validatedData = $this->validate([
                'date'          => 'required',
                'type'          => 'required',
                'subject'       => 'required',
                'description'   => 'required',
                'mechanism'     => 'required',
                'start_at'      => 'required',
                'end_at'        => 'required'
            ]
        );

        // SE GUARDA REUNIÓN
        $meeting = DB::transaction(function () {
            $meeting = Meeting::updateOrCreate(
                [
                    'id'  =>  $this->idMeeting,
                ],
                [
                    'status'                => 'saved',
                    'user_creator_id'       => auth()->id(),
                    'establishment_id'      => auth()->user()->organizationalUnit->establishment_id,
                    'date'                  => $this->date,
                    'type'                  => $this->type,
                    'subject'               => $this->subject,
                    'description'           => $this->description,
                    'mechanism'             => $this->mechanism,
                    'start_at'              => $this->start_at,
                    'end_at'                => $this->end_at,
                ]
            );

            return $meeting;
        });

        if($this->file){
            $now = now()->format('Y_m_d_H_i_s');
            $meeting->file()->updateOrCreate(
                [
                    'id' => $meeting->file ? $meeting->file->id : null,
                ],
                [
                    'storage_path' => '/ionline/meetings/attachments/'.$now.'_meet_'.$meeting->id.'.'.$this->file->extension(),
                    'stored' => true,
                    'name' => 'adjunto.pdf',
                    // 'valid_types' => json_encode(["pdf", "xls"]),
                    // 'max_file_size' => 10,
                    'stored_by_id' => auth()->id(),
                ]
            );
            $meeting->file = $this->file->storeAs('/ionline/meetings/attachments', $now.'_meet_'.$meeting->id.'.'.$this->file->extension(), 'gcs');
        }

        //SE GUARDA GROUPING (Asociaciones / Federaciones / Reunión Mesas y Comités de Trabajos) PARTICIPANTES
        if(!empty($this->groupings)){
            foreach($this->groupings as $grouping){
                // dd($this->groupings, $grouping);
                Grouping::updateOrCreate(
                    [
                        'id' => $grouping['id'] ? $grouping['id'] : null,
                    ],
                    [
                        'type'          => $grouping['type'], 
                        'name'          => $grouping['name'],
                        'user_id'       => $grouping['user_id'],
                        'meeting_id'    => $meeting->id
                    ]
                );
            }
        }

        //SE GUARDA COMPROMISOS
        if(!empty($this->commitments)){
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
                        'priority'              => $commitment['priority'],
                        'closing_date'          => $commitment['closing_date'],
                        'meeting_id'            => $meeting->id,
                        'user_id'               => $commitment['user_id']
                    ]
                );
            }
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
            $this->description  = $this->meetingToEdit->description;
            $this->mechanism    = $this->meetingToEdit->mechanism;
            $this->start_at     = $this->meetingToEdit->start_at;
            $this->end_at       = $this->meetingToEdit->end_at;
        }
    }

    #[On('searchedUser')]
    public function searchedUser($userId){
        $this->searchedUser = User::find($userId);
    }

    public function addGrouping(){
        $validatedData = $this->validate([
                'typeGrouping' => 'required',
                ($this->groupingInput == 'groups') ? 'nameGrouping' : 'nameGrouping'    => ($this->groupingInput == 'groups') ? 'required' : '',
                ($this->groupingInput == 'user') ? 'searchedUser' : 'searchedUser'    => ($this->groupingInput == 'user') ? 'required' : '',
            ]
        );

        $this->groupings[] = [
            'id'            => '',
            'type'          => $this->typeGrouping,
            'name'          => $this->nameGrouping,
            'user_id'       => ($this->searchedUser) ? $this->searchedUser->id : null,
            'user_name'     => ($this->searchedUser) ? $this->searchedUser->fullName : null,
            'meeting_id'    => ($this->meetingToEdit) ? $this->meetingToEdit->id : null,
        ];

        $this->cleanGrouping();
    }

    public function cleanGrouping(){
        $this->typeGrouping = null;
        $this->nameGrouping = null;
        $this->groupingInput = null;
    }

    public function setGroupings(){
        if($this->meetingToEdit){
            foreach($this->meetingToEdit->groupings as $grouping){
                $this->groupings[] = [
                    'id'            => $grouping->id,
                    'type'          => $grouping->type,
                    'name'          => $grouping->name,
                    'user_id'       => $grouping->user_id,
                    'user_name'     => ($grouping->type == "funcionario") ? $grouping->groupingUser->fullName  : null,
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
        $validatedData = $this->validate([
                'commitmentDescription'     => 'required',
                'typeResponsible'           => 'required',
                ($this->typeResponsible == 'individual') ? 'searchedCommitmentUser' : 'searchedCommitmentUser'  => ($this->typeResponsible == 'individual') ? 'required' : '',
                ($this->typeResponsible == 'ou') ? 'searchedCommitmentOu' : 'searchedCommitmentOu'              => ($this->typeResponsible == 'ou') ? 'required' : '',
                'priority'           => 'required',
            ]
        );

        $this->commitments[] = [
            'id'                    => '',
            'description'           => $this->commitmentDescription,
            'type'                  => $this->typeResponsible,
            'commitment_user_id'    => ($this->typeResponsible == 'individual') ? $this->searchedCommitmentUser->id : null,
            'commitment_user_name'  => ($this->typeResponsible == 'individual') ? $this->searchedCommitmentUser->fullName : null,
            'commitment_ou_id'      => ($this->typeResponsible == 'ou') ? $this->searchedCommitmentOu->id : null,
            'commitment_ou_name'    => ($this->typeResponsible == 'ou') ? $this->searchedCommitmentOu->name : null,
            'closing_date'          => $this->closingDate,
            'priority'              => $this->priority,
            'requirement_id'        => '',
            'user_id'               => auth()->id()
        ];

        $this->cleanCommitment();
    }

    public function cleanCommitment(){
        $this->commitmentDescription    = null;
        $this->typeResponsible          = null;
        $this->closingDate              = null;
        $this->priority                 = null;
    }

    public function setCommitments(){
        if($this->meetingToEdit){
            foreach($this->meetingToEdit->commitments as $commitment){
                $this->commitments[] = [
                    'id'                    => $commitment->id,
                    'description'           => $commitment->description,
                    'type'                  => $commitment->type,
                    'commitment_user_id'    => $commitment->commitment_user_id,
                    'commitment_user_name'  => ($commitment->commitment_user_id) ? $commitment->commitmentUser->fullName : null,
                    'commitment_ou_id'      => $commitment->commitment_ou_id,
                    'commitment_ou_name'    => ($commitment->commitment_ou_id) ? $commitment->commitmentOrganizationalUnit->name : null,
                    'priority'              => $commitment->priority,
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

    public function sentSgr(){
        /** Crear el requerimiento */
        foreach($this->commitments as $key => $commitment){
            if($commitment['commitment_user_id'] != null){
                $to_authority = Authority::getAmIAuthorityOfMyOu(today(),'manager',$commitment['commitment_user_id']);
                $toUser = User::find($commitment['commitment_user_id']);
            }

            if($commitment['commitment_ou_id'] != null){
                $toUser = Authority::getTodayAuthorityManagerFromDate($commitment['commitment_ou_id']);
                $to_authority = true;
            }
            
            $requirement = Requirement::create([
                'subject'       => $this->meetingToEdit->subject,
                'priority'      => $commitment['priority'],
                'status'        => 'creado',
                'limit_at'      => $commitment['closing_date'],
                'user_id'       => auth()->id(),
                'parte_id'      => null,
                'group_number'  => null,
                'to_authority'  => $to_authority,
                'category_id'   => null,
            ]);

            $event = Event::create([
                'body'              => $commitment['description'],
                'status'            => 'creado',
                'from_user_id'      => auth()->id(),
                'from_ou_id'        => auth()->user()->organizational_unit_id,
                'to_user_id'        => ($commitment['commitment_user_id'] != null) ? $toUser->id : $toUser->user_id,
                'to_ou_id'          => $toUser->organizational_unit_id,
                'requirement_id'    => $requirement->id,
                'to_authority'      => $to_authority,
            ]);

            // Notifica por correo al destinatario, en cola
            if($commitment['commitment_user_id'] != null){
                $toUser->notify(new NewSgr($requirement, $event));
            }
            else{
                $authorityNotify = User::find($toUser->user_id);
                $authorityNotify->notify(new NewSgr($requirement, $event));
            }
            
            // Marca los eventos como vistos
            $requirement->setEventsAsViewed;

            // SE GUARDA EL ID DEL REQUIREMENT EN REUNION
            $commitmentStatus =  Commitment::find($commitment['id']);
            $commitmentStatus->requirement_id = $requirement->id;
            $commitmentStatus->save();
        }

        
        // SE GUARDA STATUS EN REUNION
        $this->meetingToEdit->status = 'sgr';
        $this->meetingToEdit->save();

        return redirect()->route('meetings.show', $this->meetingToEdit);
    }

    #[On('searchedCommitmentUser')]
    public function searchedCommitmentUser(User $user){
        $this->searchedCommitmentUser = $user;
    }

    #[On('searchedCommitmentOu')]
    public function searchedCommitmentOu(OrganizationalUnit $organizationalUnit){
        $this->searchedCommitmentOu = $organizationalUnit;
    }

    public function show_file(Meeting $meetingToEdit){
        // dd($meetingToEdit->file);

        return Storage::response($meetingToEdit->file->storage_path);
    }

    public function updatedTypeGrouping($groupingInput){
        if($groupingInput == 'funcionario'){
            $this->groupingInput = 'user';
        }
        else{
            $this->groupingInput = 'groups';
        }
    }
}

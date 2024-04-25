<?php

namespace App\Http\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;
use App\Models\Parameters\Estament;
use App\Models\Parameters\ContractualCondition;
use App\Models\User;
use App\Models\Trainings\StrategicAxes;
use App\Models\Trainings\TrainingCost;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;
use App\Models\UserExternal;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Models\Documents\Approval;
use App\Models\Parameters\Parameter;

class TrainingCreate extends Component
{
    use WithFileUploads;

    public $run, $dv, 
    $selectedEstament, $degree, $selectedContractualCondition, 
    $organizationalUnitUser, $establishmentUser, 
    $email, $telephone,
    $selectedStrategicAxis,
    $objective,
    $activityName,
    $activityType, $otherActivityType, $disabledInputOtherActivityType = 'disabled',
    $mechanism, $schuduled,
    $activityDateStartAt, $activityDateEndAt, $totalHours,
    $permissionDateStartAt, $permissionDateEndAt, $place,
    $workingDay,
    $technicalReasons,
    $feedback_type;

    // public $trainingCosts, $typeTrainingCost, $otherTypeTrainingCost, $disabledInputOtherTypeTrainingCost = 'disabled',$exist, $expense;

    public $file, $iterationFileClean = 0, $municipalProfile, $userExternal = null, $searchedUserName, 
    $disabledSearchedUserNameInput = 'disabled';

    public $form, $bootstrap;

    /* Training to edit */
    public $trainingToEdit;
    public $training;
    public $idTraining;

    /* trainingCost to edit 
    public $trainingCostToEdit;
    public $idTrainingCost;
    */

    // Listeners
    public $searchedUser;
    public $disabledUserInputs = "disabled";
    protected $listeners = ['searchedUser'];

    protected function messages(){
        return [
            // Mensajes para Training

            'searchedUser.required'                 => 'Debe ingresar Usuario que realiza capacitación.',
            'selectedEstament.required'             => 'Debe ingresar Estamento de funcionario.',
            'degree.required'                       => 'Debe ingresar Grado de funcionario.',
            'selectedContractualCondition.required' => 'Debe ingresar Calidad Contractual de funcionario.',
            'email.required'                        => 'Debe ingresar Correo Electrónico de funcionario.',
            'telephone.required'                    => 'Debe ingresar Teléfonos de funcionario.',
            
            'selectedStrategicAxis.required'        => 'Debe ingresar Eje Estratégico.',
            'objective.required'                    => 'Debe ingresar Objetivo.',
            'activityName.required'                 => 'Debe ingresar Nombre de Actividad.',
            'activityType.required'                 => 'Debe ingresar Tipo de Actividad.',
            'otherActivityType.required'            => 'Debe ingresar Otro Tipo de Actividad.',
            'mechanism.required'                    => 'Debe ingresar Modalidad de Aprendizaje.',
            'schuduled.required'                    => 'Debe ingresar Actividad Programada.',
            'activityDateStartAt.required'          => 'Debe ingresar Fecha Inicio Actividad.',
            'activityDateEndAt.required'            => 'Debe ingresar Fecha Termino Actividad.',
            'totalHours.required'                   => 'Debe ingresar Total Horas Cronológicas.',
            'permissionDateStartAt.required'        => 'Debe ingresar Solicita Permiso Desde.',
            'permissionDateEndAt.required'          => 'Debe ingresar Solicita Permiso Hasta.',
            'place.required'                        => 'Debe ingresar Lugar.',
            'workingDay.required'                   => 'Debe ingresar Jornada.',
            'technicalReasons.required'             => 'Debe ingresar Fundamento o Razones Técnicas.',

            //  MENSAJES PARA COSTOS
            /*
            'trainingCosts.required'                => 'Debe ingresar al menos un tipo de costo',
            'typeTrainingCost.required'             => 'Ingresar un Tipo de Costo.',
            'otherTypeTrainingCost.required'        => 'Debe especificar un Tipo de Costo.',
            'exist.required'                        => 'Debe ingresar Sí/No.',
            'expense.required'                      => 'Debe ingresar $ monto.',
            */
        ];
    }

    public function render()
    {
        $estaments = Estament::orderBy('id')->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();
        $strategicAxes = StrategicAxes::orderBy('number', 'ASC')->get();

        if(auth()->guard('external')->check() == true && Route::is('trainings.external_create') ){
            $this->userExternal = UserExternal::where('id',Auth::guard('external')->user()->id)->first();
            $this->searchedUser = $this->userExternal;
            $this->searchedUserId = $this->userExternal->id;
            $this->searchedUserName = $this->userExternal->FullName;
            $this->run = $this->userExternal->id;
            $this->dv = $this->userExternal->dv;
            $this->email = $this->userExternal->email;
            $this->telephone = ($this->userExternal->phone_number) ? $this->userExternal->phone_number : null;
        }

        return view('livewire.trainings.training-create', compact('estaments', 'contractualConditions', 'strategicAxes'));
    }

    public function mount($trainingToEdit){
        if(!is_null($trainingToEdit)){
            $this->training = $trainingToEdit;
            $this->setTraining();
        }
    }

    public function save(){
        $this->validateMessage = 'training';

        $validatedData = $this->validate([
            'searchedUser'                  => 'required',
            'selectedEstament'              => 'required',
            'degree'                        => 'required',
            'selectedContractualCondition'  => 'required',
            'email'                         => 'required',
            'telephone'                     => 'required',

            'selectedStrategicAxis'         => 'required',
            'objective'                     => 'required',
            'activityName'                  => 'required',
            'activityType'                                                              => 'required',
            ($this->activityType == "otro") ? 'otherActivityType' : 'otherActivityType' => ($this->activityType == "otro") ? 'required' : '',
            'mechanism'                                                                 => 'required',
            'schuduled'                                                                 => 'required',
            'activityDateStartAt'                                                       => 'required',
            'activityDateEndAt'                                                         => 'required',
            'totalHours'                                                                => 'required',
            'permissionDateStartAt'                                                     => 'required',
            'permissionDateEndAt'                                                       => 'required',
            'place'                                                                     => 'required',
            'workingDay'                                                                => 'required',
            'technicalReasons'                                                          => 'required',

            // 'trainingCosts'                                                             => 'required'
            
        ]);

        // SE GUARDA REUNIÓN
        $training = DB::transaction(function () {
            $training = Training::updateOrCreate(
                [
                    'id'  => ($this->idTraining) ? $this->idTraining : '',
                ],
                [
                    'status'                    => 'saved',
                    'user_training_id'          => $this->searchedUser->id,
                    'estament_id'               => $this->selectedEstament,
                    'degree'                    => $this->degree, 
                    'contractual_condition_id'  => $this->selectedContractualCondition,
                    'organizational_unit_id'    => (auth()->guard('external')->check() == true) ? null : $this->searchedUser->organizational_unit_id,
                    'establishment_id'          => (auth()->guard('external')->check() == true) ? null : $this->searchedUser->organizationalUnit->establishment_id,
                    'email'                     => $this->email,
                    'telephone'                 => $this->telephone,
                    'strategic_axes_id'         => $this->selectedStrategicAxis,
                    'objective'                 => $this->objective,
                    'activity_name'             => $this->activityName,
                    'activity_type'             => $this->activityType, 
                    'other_activity_type'       => $this->otherActivityType,
                    'mechanism'                 => $this->mechanism, 
                    'schuduled'                 => $this->schuduled,
                    'activity_date_start_at'    => $this->activityDateStartAt, 
                    'activity_date_end_at'      => $this->activityDateEndAt, 
                    'total_hours'               => $this->totalHours,
                    'permission_date_start_at'  => $this->permissionDateStartAt, 
                    'permission_date_end_at'    => $this->permissionDateEndAt,
                    'place'                     => $this->place,
                    'working_day'               => $this->workingDay,
                    'technical_reasons'         => $this->technicalReasons,
                    'feedback_type'             => $this->feedback_type,
                    'municipal_profile'         => $this->municipalProfile,
                    'user_creator_id'           => auth()->id()
                ]
            );

            return $training;
        });

        if($this->file){
            $now = now()->format('Y_m_d_H_i_s');
            $training->file()->updateOrCreate(
                [
                    'id' => ($training->file) ? $training->file->id : null,
                ],
                [
                    'storage_path' => '/ionline/trainings/attachments/'.$now.'_training_'.$training->id.'.'.$this->file->extension(),
                    'stored' => true,
                    'name' => 'Mi adjunto.pdf',
                    'stored_by_id' => auth()->id(),
                ]
            );
            $training->file = $this->file->storeAs('/ionline/trainings/attachments', $now.'_training_'.$training->id.'.'.$this->file->extension(), 'gcs');
        }

        if(auth()->guard('external')->check() == true){
            return redirect()->route('trainings.external_own_index');
        }
        else{
            return redirect()->route('trainings.own_index');
        }
    }

    // Set Training
    private function setTraining(){
        if($this->training){
            $this->idTraining                   = $this->training->id;
            $this->searchedUser                 = $this->training->userTraining;
            $this->searchedUserName             = $this->searchedUser->FullName;
            $this->run                          = $this->searchedUser->id;
            $this->dv                           = $this->searchedUser->dv;
            $this->selectedEstament             = $this->training->estament_id;
            $this->degree                       = $this->training->degree;
            $this->selectedContractualCondition = $this->training->contractual_condition_id;
            $this->selectedContractualCondition = $this->training->contractual_condition_id;
            $this->organizationalUnitUser       = ($this->searchedUser->organizationalUnit) ? $this->searchedUser->organizationalUnit->name : null;
            $this->establishmentUser            = ($this->searchedUser->organizationalUnit) ? $this->searchedUser->organizationalUnit->establishment->name : null;
            $this->email                        = $this->training->email;
            $this->telephone                    = $this->training->telephone;
            $this->selectedStrategicAxis        = $this->training->strategic_axes_id;
            $this->objective                    = $this->training->objective;
            $this->activityName                 = $this->training->activity_name;
            $this->activityType                 = $this->training->activity_type;
            $this->otherActivityType            = $this->training->other_activity_type;
            $this->mechanism                    = $this->training->mechanism;
            $this->schuduled                    = $this->training->schuduled;
            $this->activityDateStartAt          = $this->training->activity_date_start_at;
            $this->activityDateEndAt            = $this->training->activity_date_end_at;
            $this->totalHours                   = $this->training->total_hours;
            $this->permissionDateStartAt        = $this->training->permission_date_start_at;
            $this->permissionDateEndAt          = $this->training->permission_date_end_at;
            $this->place                        = $this->training->place;
            $this->workingDay                   = $this->training->working_day;
            $this->technicalReasons             = $this->training->technical_reasons;
            $this->municipalProfile             = $this->training->municipal_profile;
        }
    }

    public function addTrainingCost(){
        /*
        $this->validateMessage = 'training';

        $validatedData = $this->validate([
            'typeTrainingCost'          => 'required',
            ($this->typeTrainingCost == "otro") ? 'otherTypeTrainingCost' : 'otherTypeTrainingCost' => ($this->typeTrainingCost == "otro") ? 'required' : '',
            'exist'                     => 'required',
            'expense'                   => 'required'
        ]);

        $this->trainingCosts[] = [
            'id'            => '',
            'type'          => $this->typeTrainingCost,
            'other_type'    => $this->otherTypeTrainingCost,
            'exist'         => $this->exist,
            'expense'       => $this->expense,
            'training_id'   => ($this->training) ? $this->training->id : null,
        ];
        */
    }

    public function deleteTrainingCost($key){
        /*
        $itemToDelete = $this->trainingCosts[$key];

        if($itemToDelete['id'] != ''){
            unset($this->trainingCosts[$key]);
            // $objectToDelete = Grouping::find($itemToDelete['id']);
            // $objectToDelete->delete();
        }
        else{
            unset($this->trainingCosts[$key]);
        }
        */
    }

    public function searchedUser(User $user){
        $this->searchedUser = $user;
        
        $this->run = $this->searchedUser->id;
        $this->dv = $this->searchedUser->dv;
        $this->organizationalUnitUser = $this->searchedUser->organizationalUnit->name;
        $this->establishmentUser = $this->searchedUser->organizationalUnit->establishment->name;
        $this->email = $this->searchedUser->email;
        $this->telephone = ($this->searchedUser->telephones) ? $this->searchedUser->telephones->first()->minsal : null;
    }

    public function updatedActivityType($value){
        if($value == 'otro'){
            $this->disabledInputOtherActivityType = '';
        }
        else{
            $this->disabledInputOtherActivityType = 'disabled';
            $this->otherActivityType = null;
        }
    }

    public function updatedtypeTrainingCost($value){
        /*
        if($value == 'otro'){
            $this->disabledInputOtherTypeTrainingCost = '';
        }
        else{
            $this->disabledInputOtherTypeTrainingCost = 'disabled';
            $this->otherActivityType = null;
        }
        */
    }

    public function show_file(Training $training){
        return Storage::disk('gcs')->response($training->file->storage_path);
    }

    public function sentToApproval(){
        $external_approval = null;

        if(auth()->guard('external')->check() == true && $this->training->municipal_profile == 'edf'){
            //  APROBACION CORRESPONDIENTE A JEFATURA DIRECCIÓN APS
            $external_approval = $this->training->approvals()->create([
                "module"                        => "Solicitud Permiso Capacitación",
                "module_icon"                   => "fas fa-chalkboard-teacher",
                "subject"                       => 'Solicitud Permiso Capacitación <br>'.
                                                    'ID: '.$this->training->id,
                "sent_to_ou_id"                 => Parameter::get('ou', 'DireccionAPS'),
                "document_route_name"           => "trainings.show_approval",
                "document_route_params"         => json_encode(["training_id" => $this->training->id]),
                "active"                        => true,
                "previous_approval_id"          => null,
                "callback_controller_method"    => "App\Http\Controllers\Trainings\TrainingController@approvalCallback",
                "callback_controller_params"    => json_encode([
                                                        'training_id' => $this->training->id,
                                                        'process'     => null
                                                    ])
            ]);
        }
        else{
            $previousApprovalId = null;

            // AQUÍ APPROVALS DE JEFATURAS INTERNAS
            $approval = $this->training->approvals()->create([
                "module"                        => "Solicitud Permiso Capacitación",
                "module_icon"                   => "fas fa-chalkboard-teacher",
                "subject"                       => 'Solicitud Permiso Capacitación <br>'.
                                                    'ID: '.$this->training->id,
                "sent_to_ou_id"                 => $this->training->organizational_unit_id,
                "document_route_name"           => "trainings.show_approval",
                "document_route_params"         => json_encode(["training_id" => $this->training->id]),
                "active"                        => true,
                "previous_approval_id"          => ($external_approval) ? $external_approval->id : $previousApprovalId,
                "callback_controller_method"    => "App\Http\Controllers\Trainings\TrainingController@approvalCallback",
                "callback_controller_params"    => json_encode([
                                                        'training_id' => $this->training->id,
                                                        'process'     => null
                                                    ])
            ]);

            $previousApprovalId = $approval->id;

            if($this->training->userTrainingOu->father != null){
                $approval = $this->training->approvals()->create([
                    "module"                        => "Solicitud Permiso Capacitación",
                    "module_icon"                   => "fas fa-chalkboard-teacher",
                    "subject"                       => 'Solicitud Permiso Capacitación <br>'.
                                                        'ID: '.$this->training->id,
                    "sent_to_ou_id"                 => $this->training->userTrainingOu->father->id,
                    "document_route_name"           => "trainings.show_approval",
                    "document_route_params"         => json_encode(["training_id" => $this->training->id]),
                    "active"                        => false,
                    "previous_approval_id"          => $previousApprovalId,
                    "callback_controller_method"    => "App\Http\Controllers\Trainings\TrainingController@approvalCallback",
                    "callback_controller_params"    => json_encode([
                                                            'training_id' => $this->training->id,
                                                            'process'     => null
                                                        ])
                ]);

                $previousApprovalId = $approval->id;
            }
        }

        // APPROVALS DE CAPACITACIÓN
        $external_approval = $this->training->approvals()->create([
            "module"                        => "Solicitud Permiso Capacitación",
            "module_icon"                   => "fas fa-chalkboard-teacher",
            "subject"                       => 'Solicitud Permiso Capacitación <br>'.
                                                'ID: '.$this->training->id,
            "sent_to_ou_id"                 => Parameter::get('ou', 'Capacitación'),
            "document_route_name"           => "trainings.show_approval",
            "document_route_params"         => json_encode(["training_id" => $this->training->id]),
            "active"                        => false,
            "previous_approval_id"          => ($external_approval) ? $external_approval->id : $previousApprovalId,
            "callback_controller_method"    => "App\Http\Controllers\Trainings\TrainingController@approvalCallback",
            "callback_controller_params"    => json_encode([
                                                    'training_id' => $this->training->id,
                                                    'process'     => 'end'
                                                ])
        ]);

        $this->training->status = 'sent';
        $this->training->save();

        if(auth()->guard('external')->check() == true){
            return redirect()->route('trainings.external_own_index');
        }
        else{
            return redirect()->route('trainings.own_index');
        }
    }
}

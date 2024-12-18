<?php

namespace App\Livewire\Trainings;

use Livewire\Attributes\On;
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
use App\Models\Establishment;
use App\Models\ClCommune;
use App\Models\Trainings\ImpactObjectives;

class TrainingCreate extends Component
{
    use WithFileUploads;

    public $run, $dv, 
    $selectedEstament, $selectedContractualCondition, $selectedLaw, $degree, $degreeStateInput = 'disabled', $workHours, $workHoursStateInput = 'disabled',
    $organizationalUnitUser, $establishmentUser, 
    $email, $telephone,
    $selectedStrategicAxis, $selectedImpactObjective, $impactObjectives,
    $objective,
    $activityName,
    $activityType, $otherActivityType, $disabledInputOtherActivityType = 'disabled',
    $activityIn, $hiddenSearchedCommuneInput = 'hidden', $searchedCommune, $selectedAllowance,
    $mechanism, $onlineTypeMechanism, $onlineTypeMechanismStateInput = 'disabled', $schuduled,
    $activityDateStartAt, $activityDateEndAt, $totalHours,
    $permissionDateStartAt, $permissionDateEndAt, $place,
    $workingDay,
    $technicalReasons,
    $feedback_type;

    // public $trainingCosts, $typeTrainingCost, $otherTypeTrainingCost, $disabledInputOtherTypeTrainingCost = 'disabled',$exist, $expense;

    public $file, $permissionFile, $rejoinderFile, $programFile, $iterationFileClean = 0, $municipalProfile, $userExternal = null, $searchedUserName, 
    $disabledSearchedUserNameInput = 'disabled';

    public $currentPermissionFile, $currentRejoinderFile, $currentProgramFile;

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

    protected function messages(){
        return [
            // Mensajes para Training

            'searchedUser.required'                 => 'Debe ingresar Usuario que realiza capacitación.',
            'selectedEstament.required'             => 'Debe ingresar Estamento de funcionario.',
            'selectedLaw.required'                  => 'Debe ingresar Ley adscrita a funcionario.',
            'degree.required'                       => 'Debe ingresar Grado de funcionario.',
            'workHours.required'                    => 'Debe ingresar Horas de Desempeño de funcionario.',
            'selectedContractualCondition.required' => 'Debe ingresar Calidad Contractual de funcionario.',
            'email.required'                        => 'Debe ingresar Correo Electrónico de funcionario.',
            'telephone.required'                    => 'Debe ingresar Teléfonos de funcionario.',
            
            'selectedStrategicAxis.required'        => 'Debe ingresar Eje Estratégico.',
            'objective.required'                    => 'Debe ingresar Objetivo.',
            'activityName.required'                 => 'Debe ingresar Nombre de Actividad.',
            'activityType.required'                 => 'Debe ingresar Tipo de Actividad.',
            'activityIn.required'                   => 'Debe ingresar Tipo de Actividad en Chile o Exterior.',
            'searchedCommune.required'              => 'Debe ingresar Comuna.',
            'selectedAllowance.required'            => 'Debe ingresar Viático si corresponde.',
            'otherActivityType.required'            => 'Debe ingresar Otro Tipo de Actividad.',
            'mechanism.required'                    => 'Debe ingresar Modalidad de Aprendizaje.',
            'onlineTypeMechanism.required'          => 'Debe ingresar Modalidad Online de Aprendizaje.',
            'schuduled.required'                    => 'Debe ingresar Actividad Programada.',
            'activityDateStartAt.required'          => 'Debe ingresar Fecha Inicio Actividad.',
            'activityDateEndAt.required'            => 'Debe ingresar Fecha Termino Actividad.',
            'totalHours.required'                   => 'Debe ingresar Total Horas Cronológicas.',
            'permissionDateStartAt.required'        => 'Debe ingresar Solicita Permiso Desde.',
            'permissionDateEndAt.required'          => 'Debe ingresar Solicita Permiso Hasta.',
            'place.required'                        => 'Debe ingresar Lugar.',
            'workingDay.required'                   => 'Debe ingresar Jornada.',
            'technicalReasons.required'             => 'Debe ingresar Fundamento o Razones Técnicas.',
            'permissionFile.required'               => 'Debe ingresar un adjunto',
            'programFile.required'                  => 'Debe ingresar un adjunto',
            'rejoinderFile.required'                => 'Debe ingresar un adjunto',
            'municipalProfile.required'             => 'Debe ingresar un perfil'

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
        $establishments = Establishment::all();

        if(auth()->guard('external')->check() == true && Route::is('external_trainings.external_create') ){
            $this->userExternal = UserExternal::where('id',Auth::guard('external')->user()->id)->first();
            $this->searchedUser = $this->userExternal;
            $this->searchedUserId = $this->userExternal->id;
            $this->searchedUserName = $this->userExternal->fullName;
            $this->run = $this->userExternal->id;
            $this->dv = $this->userExternal->dv;
            $this->email = $this->userExternal->email;
            $this->telephone = ($this->userExternal->phone_number) ? $this->userExternal->phone_number : null;
        }

        return view('livewire.trainings.training-create', compact('estaments', 'contractualConditions', 'strategicAxes', 'establishments'));
    }

    public function mount($trainingToEdit){
        if(!is_null($trainingToEdit)){
            $this->training = $trainingToEdit;
            $this->setTraining();
            if($this->mechanism == 'online'){
                $this->updatedMechanism($this->mechanism);
            }
            if($this->activityIn == 'national'){
                $this->hiddenSearchedCommuneInput = null;
            }

            //SE CARGA EL SELECT ANIDADO A LOS EJES ESTREATEGICOS
            $this->updatedselectedStrategicAxis($this->selectedStrategicAxis);

            //SE CARGAN LOS FILES
            if($trainingToEdit->files->count() > 0){
                foreach($trainingToEdit->files as $file){
                    if($file->type == 'permission_file'){
                        $this->currentPermissionFile = $file;
                    }
                    if($file->type == 'rejoinder_file'){
                        $this->currentRejoinderFile = $file;
                    }
                    if($file->type == 'program_file'){
                        $this->currentProgramFile = $file;
                    }
                }
            }
        }
    }

    public function save(){
        $this->validateMessage = 'training';

        $this->totalHours = (float) $this->totalHours;

        $validatedData = $this->validate([
            'searchedUser'                                                                  => 'required',
            'selectedEstament'                                                              => 'required',
            'selectedLaw'                                                                   => 'required',
            'degree'                                                                        => ($this->selectedLaw == "18834") ? 'required' : '',
            'workHours'                                                                     => ($this->selectedLaw == "19664") ? 'required' : '',
            'selectedContractualCondition'                                                  => 'required',
            'email'                                                                         => 'required',
            'telephone'                                                                     => 'required',
            'selectedStrategicAxis'                                                         => 'required',
            'objective'                                                                     => 'required',
            'activityName'                                                                  => 'required',
            'activityType'                                                                  => 'required',
            'activityIn'                                                                    => 'required',
            ($this->activityIn == "national") ? 'searchedCommune' : 'searchedCommune'       => ($this->activityIn == "national") ? 'required' : '',                                                   
            'selectedAllowance'                                                             => 'required',
            ($this->activityType == "otro") ? 'otherActivityType' : 'otherActivityType'     => ($this->activityType == "otro") ? 'required' : '',
            'mechanism'                                                                     => 'required',
            'onlineTypeMechanism'                                                           => ($this->mechanism == "online") ? 'required' : '',
            'schuduled'                                                                     => 'required',
            'activityDateStartAt'                                                           => 'required',
            'activityDateEndAt'                                                             => 'required',
            'totalHours'                                                                    => 'required',
            'permissionDateStartAt'                                                         => 'required',
            'permissionDateEndAt'                                                           => 'required',
            'place'                                                                         => 'required',
            'workingDay'                                                                    => 'required',
            'technicalReasons'                                                              => 'required',
            'permissionFile'                                                                => ($this->training == null || $this->currentPermissionFile == null) ? 'required' : '',
            'rejoinderFile'                                                                 => (($this->training == null || $this->currentRejoinderFile == null) && 
                                                                                                    ($this->activityType == 'estadia pasantia' || $this->activityType == 'perfeccionamiento diplomado') && 
                                                                                                    $this->schuduled == 'no planificada' &&
                                                                                                    $this->totalHours > (float) 120)
                                                                                                    ? 'required|numeric' : '',
            'programFile'                                                                   => ($this->training == null || $this->currentProgramFile == null) ? 'required' : '',
            'municipalProfile'                                                              => (auth()->guard('external')->check() == true) ? 'required' : ''
            // 'trainingCosts'                                                              => 'required'
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
                    'user_training_type'        => get_class($this->searchedUser),
                    'estament_id'               => $this->selectedEstament,
                    'law'                       => $this->selectedLaw,
                    'degree'                    => $this->degree,
                    'work_hours'                => $this->workHours,
                    'contractual_condition_id'  => $this->selectedContractualCondition,
                    'organizational_unit_id'    => (auth()->guard('external')->check() == true) ? null : $this->searchedUser->organizational_unit_id,
                    'establishment_id'          => (auth()->guard('external')->check() == true) ? $this->establishmentUser : $this->searchedUser->organizationalUnit->establishment_id,
                    'email'                     => $this->email,
                    'telephone'                 => $this->telephone,
                    'strategic_axes_id'         => $this->selectedStrategicAxis,
                    'impact_objective_id'       => $this->selectedImpactObjective,
                    'objective'                 => $this->objective,
                    'activity_name'             => $this->activityName,
                    'activity_type'             => $this->activityType, 
                    'other_activity_type'       => $this->otherActivityType,

                    'activity_in'               => $this->activityIn, 
                    'commune_id'                => ($this->activityIn == "national") ? $this->searchedCommune->id : null, 
                    'allowance'                 => $this->selectedAllowance,

                    'mechanism'                 => $this->mechanism,
                    'online_type'               => $this->onlineTypeMechanism,
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
                    'user_creator_id'           => (auth()->guard('web')->check() == true) ? auth()->id() : null
                ]
            );

            return $training;
        });
        
        // CREAR O ACTUALIZAR PERMISO
        if($this->permissionFile){
            $now = now()->format('Y_m_d_H_i_s');
            $training->files()->updateOrCreate(
                [
                    'id' => ($training->file) ? $training->file->id : null,
                ],
                [
                    'storage_path'  => $this->permissionFile->store('ionline/trainings/attachments/permission', ['disk' => 'gcs']),
                    'stored'        => true,
                    'name'          => 'permission_'.$training->id.'.pdf',
                    'type'          => 'permission_file',
                    'stored_by_id'  => (auth()->guard('web')->check() == true) ? auth()->id() : null,
                ]
            );
        }

        // CREAR O ACTUALIZAR ARCHIVO REPLICA
        if($this->rejoinderFile){
            $now = now()->format('Y_m_d_H_i_s');
            $rejoinder = $training->files->where('type', 'rejoinder_file');

            $training->files()->updateOrCreate(
                [
                    'id' => ($rejoinder->isEmpty()) ? null : $rejoinder->id,
                ],
                [
                    'storage_path'  => $this->rejoinderFile->store('ionline/trainings/attachments/rejoinder', ['disk' => 'gcs']),
                    'stored'        => true,
                    'name'          => 'rejoinder_'.$training->id.'.pdf',
                    'type'          => 'rejoinder_file',
                    'stored_by_id'  => (auth()->guard('web')->check() == true) ? auth()->id() : null,
                ]
            );
        }

        // CREAR O ACTUALIZAR PROGRAMA
        if($this->programFile){
            $now = now()->format('Y_m_d_H_i_s');
            $program = $training->files->where('type', 'program_file');

            $training->files()->updateOrCreate(
                [
                    'id' => ($program->isEmpty()) ? null : $program->id,
                ],
                [
                    'storage_path'  => $this->programFile->store('ionline/trainings/attachments/program', ['disk' => 'gcs']),
                    'stored'        => true,
                    'name'          => 'program_'.$training->id.'.pdf',
                    'type'          => 'program_file',
                    'stored_by_id'  => (auth()->guard('web')->check() == true) ? auth()->id() : null,
                ]
            );
        }

        if(auth()->guard('external')->check() == true){
            return redirect()->route('external_trainings.external_own_index');
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
            $this->searchedUserName             = $this->searchedUser->fullName;
            $this->run                          = $this->searchedUser->id;
            $this->dv                           = $this->searchedUser->dv;
            $this->selectedEstament             = $this->training->estament_id;
            $this->selectedLaw                  = $this->training->law;
            $this->degree                       = $this->training->degree;
            $this->workHours                    = $this->training->work_hours;
            $this->selectedContractualCondition = $this->training->contractual_condition_id;
            // $this->selectedContractualCondition = $this->training->contractual_condition_id;
            $this->organizationalUnitUser       = ($this->searchedUser->organizationalUnit) ? $this->searchedUser->organizationalUnit->name : null;
            $this->establishmentUser            = ($this->searchedUser->organizationalUnit) ? $this->searchedUser->organizationalUnit->establishment->name : null;
            $this->email                        = $this->training->email;
            $this->telephone                    = $this->training->telephone;
            $this->selectedStrategicAxis        = $this->training->strategic_axes_id;
            $this->selectedImpactObjective      = $this->training->impact_objective_id;
            $this->objective                    = $this->training->objective;
            $this->activityName                 = $this->training->activity_name;
            $this->activityType                 = $this->training->activity_type;
            $this->otherActivityType            = $this->training->other_activity_type;

            $this->activityIn                   = $this->training->activity_in;
            $this->selectedAllowance            = $this->training->allowance;
            $this->searchedCommune              = $this->training->ClCommune;

            $this->mechanism                    = $this->training->mechanism;
            $this->onlineTypeMechanism          = $this->training->online_type;
            $this->schuduled                    = $this->training->schuduled;
            $this->activityDateStartAt          = $this->training->activity_date_start_at?->format('Y-m-d');
            $this->activityDateEndAt            = $this->training->activity_date_end_at?->format('Y-m-d');
            $this->totalHours                   = $this->training->total_hours;
            $this->permissionDateStartAt        = $this->training->permission_date_start_at?->format('Y-m-d');
            $this->permissionDateEndAt          = $this->training->permission_date_end_at?->format('Y-m-d');
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

    #[On('searchedUser')]
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

    public function show_file(Training $training, $type){
        return Storage::response($training->files->where('type', $type)->first()->storage_path);
    }

    public function sentToApproval(){
        $this->validateMessage = 'training';

        $this->totalHours = (float) $this->totalHours;

        $validatedData = $this->validate([
            'searchedUser'                                                                  => 'required',
            'selectedEstament'                                                              => 'required',
            'selectedLaw'                                                                   => 'required',
            'degree'                                                                        => ($this->selectedLaw == "18834") ? 'required' : '',
            'workHours'                                                                     => ($this->selectedLaw == "19664") ? 'required' : '',
            'selectedContractualCondition'                                                  => 'required',
            'email'                                                                         => 'required',
            'telephone'                                                                     => 'required',
            'selectedStrategicAxis'                                                         => 'required',
            'objective'                                                                     => 'required',
            'activityName'                                                                  => 'required',
            'activityType'                                                                  => 'required',
            'activityIn'                                                                    => 'required',
            ($this->activityIn == "national") ? 'searchedCommune' : 'searchedCommune'       => ($this->activityIn == "national") ? 'required' : '',                                                   
            'selectedAllowance'                                                             => 'required',
            ($this->activityType == "otro") ? 'otherActivityType' : 'otherActivityType'     => ($this->activityType == "otro") ? 'required' : '',
            'mechanism'                                                                     => 'required',
            'onlineTypeMechanism'                                                           => ($this->mechanism == "online") ? 'required' : '',
            'schuduled'                                                                     => 'required',
            'activityDateStartAt'                                                           => 'required',
            'activityDateEndAt'                                                             => 'required',
            'totalHours'                                                                    => 'required',
            'permissionDateStartAt'                                                         => 'required',
            'permissionDateEndAt'                                                           => 'required',
            'place'                                                                         => 'required',
            'workingDay'                                                                    => 'required',
            'technicalReasons'                                                              => 'required',
            'permissionFile'                                                                => ($this->training == null || $this->currentPermissionFile == null) ? 'required' : '',
            'rejoinderFile'                                                                 => (($this->training == null || $this->currentRejoinderFile == null) && 
                                                                                                    ($this->activityType == 'estadia pasantia' || $this->activityType == 'perfeccionamiento diplomado') && 
                                                                                                    $this->schuduled == 'no planificada' &&
                                                                                                    $this->totalHours > (float) 120)
                                                                                                    ? 'required|numeric' : '',
            'programFile'                                                                   => ($this->training == null || $this->currentProgramFile == null) ? 'required' : '',
            'municipalProfile'                                                              => (auth()->guard('external')->check() == true) ? 'required' : ''
            // 'trainingCosts'                                                              => 'required'
        ]);

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
            return redirect()->route('external_trainings.external_own_index');
        }
        else{
            return redirect()->route('trainings.own_index');
        }
    }

    public function updatedSelectedLaw($value){
        if($value == '18834'){
            $this->degree = null;
            $this->degreeStateInput = null;
            $this->workHours = null;
            $this->workHoursStateInput = 'disabled';
        }
        if($value == '19664'){
            $this->degree = null;
            $this->degreeStateInput = 'disabled';
            $this->workHours = null;
            $this->workHoursStateInput = null;
        }
    }

    public function updatedMechanism($value){
        if($value == 'online'){
            // $this->onlineTypeMechanism = null;
            $this->onlineTypeMechanismStateInput = null;
        }
        else{
            $this->onlineTypeMechanism = null;
            $this->onlineTypeMechanismStateInput = 'disabled';
        }
    }

    public function updatedActivityIn($value){
        if($value == "international"){
            $this->hiddenSearchedCommuneInput = "hidden";
            $this->searchedCommune = null;
        }
        else{
            $this->hiddenSearchedCommuneInput = null;
        }
    }

    #[On('searchedCommune')] 
    public function searchedCommune(ClCommune $commune)
    {
        $this->searchedCommune = $commune;
    }

    public function updatedselectedStrategicAxis($value){
        $this->impactObjectives = ImpactObjectives::where('strategic_axis_id', $value)->get();
    }

    public function deleteFile($value){
        // Encontrar el archivo basado en el tipo
        $file = $this->trainingToEdit->files->where('type', $value)->first();

        if ($file) {
            // Eliminar el archivo del almacenamiento
            Storage::disk('gcs')->delete($file->storage_path);

            // Eliminar el registro de la base de datos (si corresponde)
            $file->delete();

            // return response()->json(['message' => 'Archivo eliminado exitosamente.']);
        }

        // return response()->json(['message' => 'Archivo no encontrado.'], 404);

        if(auth()->guard('external')->check() == true){
            return redirect()->route('external_trainings.external_own_index');
        }
        else{
            return redirect()->route('trainings.edit', $this->trainingToEdit);
        }
    }
}

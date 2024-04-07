<?php

namespace App\Http\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;
use App\Models\Parameters\Estament;
use App\Models\Parameters\ContractualCondition;
use App\Models\User;
use App\Models\Trainings\StrategicAxes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrainingCreate extends Component
{
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

    public $trainingCosts, $typeTrainingCost, $otherTypeTrainingCost, $disabledInputOtherTypeTrainingCost = 'disabled',$exist, $expense;

    /* Training to edit */
    public $trainingToEdit;
    public $idTraining;

    /* trainingCost to edit */
    public $trainingCostToEdit;
    public $idTrainingCost;

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
            'trainingCosts.required'                => 'Debe ingresar al menos un tipo de costo',
            'typeTrainingCost.required'             => 'Ingresar un Tipo de Costo.',
            'otherTypeTrainingCost.required'        => 'Debe especificar un Tipo de Costo.',
            'exist.required'                        => 'Debe ingresar Sí/No.',
            'expense.required'                      => 'Debe ingresar $ monto.',
            
        ];
    }

    public function render()
    {
        $estaments = Estament::orderBy('id')->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();
        $strategicAxes = StrategicAxes::orderBy('number', 'ASC')->get();

        return view('livewire.trainings.training-create', compact('estaments', 'contractualConditions', 'strategicAxes'));
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

            'trainingCosts'                                                             => 'required'
            
        ]);

        // SE GUARDA REUNIÓN
        $training = DB::transaction(function () {
            $training = Training::updateOrCreate(
                [
                    'id'  =>  '',
                ],
                [
                    'status'                    => 'pending',
                    'user_training_id'          => $this->searchedUser->id,
                    'estament_id'               => $this->selectedEstament,
                    'degree'                    => $this->degree, 
                    'contractual_condition_id'  => $this->selectedContractualCondition,
                    'organizationl_unit_id'     => $this->searchedUser->organizational_unit_id,
                    'establishment_id'          => $this->searchedUser->organizationalUnit->establishment_id,
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
                    'technical_reasons'         => $this->technicalReasons,
                    'feedback_type'             => $this->feedback_type,
                    'user_creator_id'           => auth()->id()
                ]
            );

            return $training;
        });
    }

    public function addTrainingCost(){
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
            'training_id'   => ($this->trainingToEdit) ? $this->trainingToEdit->id : null,
        ];
    }

    public function deleteTrainingCost($key){
        $itemToDelete = $this->trainingCosts[$key];

        if($itemToDelete['id'] != ''){
            unset($this->trainingCosts[$key]);
            /*
            $objectToDelete = Grouping::find($itemToDelete['id']);
            $objectToDelete->delete();
            */
        }
        else{
            unset($this->trainingCosts[$key]);
        }
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

    public function updatedactivityType($value){
        if($value == 'otro'){
            $this->disabledInputOtherActivityType = '';
        }
        else{
            $this->disabledInputOtherActivityType = 'disabled';
            $this->otherActivityType = null;
        }
    }

    public function updatedtypeTrainingCost($value){
        if($value == 'otro'){
            $this->disabledInputOtherTypeTrainingCost = '';
        }
        else{
            $this->disabledInputOtherTypeTrainingCost = 'disabled';
            $this->otherActivityType = null;
        }
    }
}

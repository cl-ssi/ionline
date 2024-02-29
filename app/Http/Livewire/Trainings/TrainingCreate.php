<?php

namespace App\Http\Livewire\Trainings;

use Livewire\Component;

use App\Models\Trainings\Training;
use App\Models\Parameters\Estament;
use App\Models\Parameters\ContractualCondition;
use App\User;
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
    $technicalReasons,
    $feedback_type;

    // Listeners
    public $searchedUser;
    public $disabledUserInputs = "disabled";
    protected $listeners = ['searchedUser'];

    public function render()
    {
        $estaments = Estament::orderBy('id')->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();
        $strategicAxes = StrategicAxes::orderBy('number', 'ASC')->get();

        return view('livewire.trainings.training-create', compact('estaments', 'contractualConditions', 'strategicAxes'));
    }

    public function save(){
        // SE GUARDA REUNIÓN
        $meeting = DB::transaction(function () {
            $meeting = Training::updateOrCreate(
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
                    'email'                      => $this->email,
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

            return $meeting;
        });
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
}

<?php

namespace App\Http\Livewire\IdentifyNeeds;

use Livewire\Component;

use App\Models\IdentifyNeeds\IdentifyNeed;
use App\Models\IdentifyNeeds\LearningGoal;

use Illuminate\Support\Facades\DB;

class CreateIdentifyNeed extends Component
{
    public $subject;

    public $reason;
    public $behaviors;
    public $performanceEvaluation;
    public $observationOfPerformance;
    public $reportFromOtherUsers;
    public $organizationalUnitIndicators;
    public $other;

    public $otherDetail;
    public $otherDetailInputStatus = 'disabled';

    public $goal;
    public $expectedResults;
    public $longtermImpact;
    public $immediateResults;
    public $performanceGoals;

    /* OBJETIVOS DE APRENDIZAJES $learningGoals; */
    public $inputs = [];
    public $i = 1;
    public $count = 0;
    public $learningGoals = null;
    public $learningGoal = null;
    public $editlearningGoalIdRender = null;
    public $learningGoalsDescriptions;

    public $learningGoalsDescriptionId = null;

    public $currentTrainingLevel;
    public $needTrainingLevel;
    public $expertiseRequired;

    public $justification;
    public $canSolveTheNeed;

    public $identifyNeedId;
    
    public function render()
    {
        return view('livewire.identify-needs.create-identify-need');
    }

    public function updatedOther($value)
    {
        if($value == "true"){
            $this->otherDetailInputStatus = '';
        }
        else{
            $this->otherDetailInputStatus = 'disabled';
            $this->otherDetail = null;
        }
    }

    /* AGREGAR, ELIMINAR OBJETIVOS DE APRENDIZAJES */

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
        $this->messageMaxRoles = null;
    }

    /* ELIMINAR, EDITAR REGISTRO OBJETIVOS DE APRENDIZAJES */

    public function deleteRole($role)
    {
        $this->role = Role::find($role['id']);
        $this->role->delete();
    }

    public function editRole($role)
    {
        $this->editRoleIdRender = $role['id'];
        $this->description      = $role['description'];
    }

    public function saveEditRole($role)
    {
        $this->role = Role::find($role['id']);
        $this->role->description = $this->description;
        
        $this->role->save();
        $this->editRoleIdRender = null;
    }

    public function cancelEdit(){
        $this->editRoleIdRender = null;
    }

    /* ******************************************** */

    public function save($identify_need_status){
        $this->identify_need_status = $identify_need_status;

        if($this->identify_need_status == 'save'){
            $identifyNeed = DB::transaction(function () {
                $identifyNeed = IdentifyNeed::updateOrCreate(
                    [
                        'id'  =>  $this->identifyNeedId,
                    ],
                    [
                        'subject'                           => $this->subject,

                        'reason'                            => $this->reason,
                        'behaviors'                         => $this->behaviors,
                        'performance_evaluation'            => $this->performanceEvaluation,
                        'observation_of_performance'        => $this->observationOfPerformance,
                        'report_from_other_users'           => $this->reportFromOtherUsers,
                        'organizational_unit_indicators'    => $this->organizationalUnitIndicators,
                        'other'                             => $this->otherDetail,
                        'goal'                              => $this->goal,
                        'expected_results'                  => $this->expectedResults,
                        'longterm_impact'                   => $this->longtermImpact,
                        'immediate_results'                 => $this->immediateResults,
                        'performance_goals'                 => $this->performanceGoals,
                        'current_training_level'            => $this->currentTrainingLevel,
                        'need_training_level'               => $this->needTrainingLevel,
                        'expertise_required'                => $this->expertiseRequired,
                        'justification'                     => $this->justification,
                        'can_solve_the_need'                => $this->canSolveTheNeed,

                        'organizational_unit_id'    => auth()->user()->organizational_unit_id,
                        'user_id'                   => auth()->user()->id
                    ]
                );
    
                return $identifyNeed;
            });

            foreach($this->learningGoalsDescriptions as $learningGoalsDescription){
                $lgDescription = DB::transaction(function () use ($learningGoalsDescription, $identifyNeed) {
                    $lgDescription = LearningGoal::updateOrCreate(
                        [
                            'id'  =>  $this->learningGoalsDescriptionId,
                        ],
                        [
                            'description'       => $learningGoalsDescription,
                            'identify_need_id'  => $identifyNeed->id
                        ]
                    );
    
                    return $lgDescription;
                });
            }
        }
        else{
            $this->validateMessage = 'description';

            $validatedData = $this->validate([
                'userResponsibleId' => 'required'
            ]);
        }

        // return redirect()->route('identify_need.own', $purchasePlan->id);
    }

    public function mount($identifyNeedToEdit)
    {   
        if(!is_null($identifyNeedToEdit)){
            $this->identifyNeedToEdit = $identifyNeedToEdit;
            $this->setIdentifyNeed();
        }
    }

    public function setIdentifyNeed(){
        if($this->identifyNeedToEdit){
            $this->identifyNeedId               = $this->identifyNeedToEdit->id;

            $this->subject                      = $this->identifyNeedToEdit->subject;

            $this->reason                       = $this->identifyNeedToEdit->reason;
            $this->behaviors                    = $this->identifyNeedToEdit->behaviors;
            $this->performanceEvaluation        = $this->identifyNeedToEdit->performance_evaluation;
            $this->observationOfPerformance     = $this->identifyNeedToEdit->observation_of_performance;
            $this->reportFromOtherUsers         = $this->identifyNeedToEdit->report_from_other_users;
            $this->organizationalUnitIndicators = $this->identifyNeedToEdit->organizational_unit_indicators;
            
            if($this->identifyNeedToEdit->other != null){
                $this->other                    = 1;
                $this->otherDetailInputStatus   = '';
                $this->otherDetail              = $this->identifyNeedToEdit->other;
            }

            $this->goal                         = $this->identifyNeedToEdit->goal;
            $this->expectedResults              = $this->identifyNeedToEdit->expected_results;
            $this->longtermImpact               = $this->identifyNeedToEdit->longterm_impact;
            $this->immediateResults             = $this->identifyNeedToEdit->immediate_results;
            $this->performanceGoals             = $this->identifyNeedToEdit->performance_goals;

            $this->currentTrainingLevel         = $this->identifyNeedToEdit->current_training_level;
            $this->needTrainingLevel            = $this->identifyNeedToEdit->need_training_level;
            $this->expertiseRequired            = $this->identifyNeedToEdit->expertise_required;
            $this->justification                = $this->identifyNeedToEdit->justification;
            $this->canSolveTheNeed              = $this->identifyNeedToEdit->can_solve_the_need;
        }
    }
}

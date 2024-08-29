<?php

namespace App\Livewire\IdentifyNeeds;

use Livewire\Component;
use App\Models\IdentifyNeeds\LearningGoal;

use Illuminate\Support\Facades\DB;

class CreateLearningGoal extends Component
{
    /* OBJETIVOS DE APRENDIZAJES $learningGoals; */
    public $inputs = [];
    public $i = 1;
    public $count = 0;
    public $learningGoals = null;
    public $learningGoal = null;
    public $editLearningGoalIdRender = null;
    public $learningGoalsDescriptions = null;

    public $learningGoalsDescriptionId = null;

    public $identifyNeedToEdit;

    public function render()
    {
        return view('livewire.identify-needs.create-learning-goal');
    }


    public function mount($identifyNeedToEdit)
    {   
        if(!is_null($identifyNeedToEdit)){
            $this->identifyNeedToEdit = $identifyNeedToEdit;
            $this->learningGoals = $identifyNeedToEdit->learningGoals;
        }
    }

    /*
    public function setIdentifyNeed(){
        if($this->identifyNeedToEdit){
            $this->learningGoals = $this->identifyNeedToEdit->id;
        }
    }
    */

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
        $this->learningGoalsDescriptions[$this->count] = null;
        unset($this->inputs[$i]);
        $this->count--;
    }
    
    /*
    public function updatedLearningGoalsDescriptions(){
        $this->dispatch('learningGoalsDescriptions', $this->learningGoalsDescriptions);
    }
    */

    public function save(){
        $dnc_id = $this->identifyNeedToEdit->id;

        foreach($this->learningGoalsDescriptions as $description){
            $lgDescription = DB::transaction(function () use ($dnc_id, $description) {
                $lgDescription = LearningGoal::updateOrCreate(
                    [
                        'id'  =>  $this->learningGoalsDescriptionId
                    ],
                    [
                        'description'       => $description,
                        'identify_need_id'  => $dnc_id
                    ]
                );
                return $lgDescription;
            });
        }

        return redirect()->route('identify_need.edit', $this->identifyNeedToEdit);
    }

    /* ELIMINAR, EDITAR REGISTRO OBJETIVOS DE APRENDIZAJES */

    public function deleteRole($learningGoal)
    {
        $this->learningGoal = LearningGoal::find($learningGoal['id']);
        $this->learningGoal->delete();
    }

    public function editRole($learningGoal)
    {
        $this->editLearningGoalIdRender = $learningGoal['id'];
        $this->description              = $learningGoal['description'];
    }

    public function saveEditRole($learningGoal)
    {
        $this->learningGoal = LearningGoal::find($learningGoal['id']);
        $this->learningGoal->description = $this->description;
        
        $this->learningGoal->save();
        $this->editLearningGoalIdRender = null;
        // $this->mount($this->identifyNeedToEdit);
        return redirect()->route('identify_need.edit', $this->identifyNeedToEdit);
    }

    public function cancelEdit(){
        $this->editLearningGoalIdRender = null;
    }

    /* ******************************************** */
    
    public function updatedLearningGoals(){
        $this->render();
    }
    
}

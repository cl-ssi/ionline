<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\Parameters\Estament;
use App\Models\Parameters\Area;
use App\Models\Parameters\ContractualCondition;

class CreateJobPositionProfiles extends Component
{
    public $selectedContractualCondition = null;
    public $salaryStateInput = 'readonly';
    public $degreeStateInput = 'readonly';

    public $selectedEstament = null;
    public $selectedArea = null;

    public $selectedLaw = null;

    public $lawStateOption = 'disabled';

    public $action;

    public $jobPositionProfile;

    public $areas;
    public $areaSelected = null;

    public function mount(){
        if($this->jobPositionProfile){
            $this->selectedContractualCondition = $this->jobPositionProfile->contractual_condition_id;

            switch($this->selectedContractualCondition) {
                case 1:
                    $this->salaryStateInput = 'readonly';
                    $this->degreeStateInput = '';
                    break;
                
                case 2:
                    $this->salaryStateInput = '';
                    $this->degreeStateInput = 'readonly';
                    break;
    
                case 3:
                    $this->salaryStateInput = 'readonly';
                    $this->degreeStateInput = '';
                    break;
    
                default:
                    $this->salaryStateInput = 'readonly';
                    $this->degreeStateInput = 'readonly';
                    break;
            }

            $this->selectedLaw = $this->jobPositionProfile->law;
            if($this->selectedLaw == 18834){
                $this->lawStateOption = 'disabled';
            }
            else{
                $this->lawStateOption = '';
            }

            //ADMINISTRATIVO
            $this->selectedEstament = $this->jobPositionProfile->estament_id;
            $this->selectedArea     = $this->jobPositionProfile->area_id;
            if($this->selectedEstament == 1){
                $this->areas = Area::whereIn('id', [2,4])
                    ->orderBy('id')
                    ->get();
            }
            //AUXILIAR
            if($this->selectedEstament== 2){
                $this->areas = Area::whereIn('id', [2,5])
                    ->orderBy('id')
                    ->get();
            }
            //PROFESIONAL
            if($this->selectedEstament == 3){
                $this->areas = Area::whereIn('id', [2,3,4,5])
                    ->orderBy('id')
                    ->get();
            }
            //TÉCNICO
            if($this->selectedEstament == 4){
                $this->areas = Area::whereIn('id', [2,4,5])
                    ->orderBy('id')
                    ->get();
            }
        }
    }

    public function render()
    {
        $estaments = Estament::orderBy('id')->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();

        return view('livewire.job-position-profile.create-job-position-profiles', 
            compact('estaments', 'contractualConditions'));
    }

    
    public function updatedSelectedContractualCondition($selectedContractualConditionId)
    {
        if($this->selectedLaw == '18834'){
            if($selectedContractualConditionId == '1' || $selectedContractualConditionId == '3'){
                $this->salaryStateInput = 'readonly';
                $this->degreeStateInput = '';
            }
            if($selectedContractualConditionId == '2'){
                $this->salaryStateInput = '';
                $this->degreeStateInput = 'readonly';
            }
        }

        /*
        if($selectedContractualConditionId == 1 && $this->selectedLaw == '18834'){
            $this->salaryStateInput = 'readonly';
            $this->degreeStateInput = '';
        }
        if($selectedContractualConditionId == 1 && $this->selectedLaw == '18834'){
            $this->salaryStateInput = 'readonly';
            $this->degreeStateInput = '';
        }
        switch($selectedContractualConditionId) {
            case 1:
                $this->salaryStateInput = 'readonly';
                $this->degreeStateInput = '';
                break;
            
            case 2:
                $this->salaryStateInput = '';
                $this->degreeStateInput = 'readonly';
                break;

            case 3:
                $this->salaryStateInput = 'readonly';
                $this->degreeStateInput = '';
                break;

            default:
                $this->salaryStateInput = 'readonly';
                $this->degreeStateInput = 'readonly';
                break;
        }*/
    }

    public function updatedSelectedLaw($selectedLawId)
    {
        if($selectedLawId == 18834){
            // dd($this->selectedContractualCondition);
            if($this->selectedContractualCondition == 1 || $this->selectedContractualCondition == 3){
                $this->salaryStateInput = 'readonly';
                $this->degreeStateInput = '';
            }
            if($this->selectedContractualCondition == 2){
                $this->salaryStateInput = '';
                $this->degreeStateInput = 'readonly';
            }

            $this->lawStateOption = 'disabled';
        }
        else{
            //SE INHABILITA SALARIO Y GRADO
            $this->salaryStateInput = '';
            $this->salaryStateInput = 'readonly';
            $this->degreeStateInput = '';
            $this->degreeStateInput = 'readonly';

            //HORAS DISPONIBLES
            $this->lawStateOption = '';
        }
    }

    public function updatedSelectedEstament($selectedEstamentId){
        //ADMINISTRATIVO
        if($selectedEstamentId == 1){
            $this->areas = Area::whereIn('id', [2,4])
                ->orderBy('id')
                ->get();
        }
        //AUXILIAR
        if($selectedEstamentId == 2){
            $this->areas = Area::whereIn('id', [2,5])
                ->orderBy('id')
                ->get();
        }
        //PROFESIONAL
        if($selectedEstamentId == 3){
            $this->areas = Area::whereIn('id', [2,3,4,5])
                ->orderBy('id')
                ->get();
        }
        //TÉCNICO
        if($selectedEstamentId == 4){
            $this->areas = Area::whereIn('id', [2,4,5])
                ->orderBy('id')
                ->get();
        }
    }
}

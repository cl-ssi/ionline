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

    public $selectedLaw = null;

    public $lawStateOption = 'disabled';

    public $action;

    public $jobPositionProfile;

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
        }
    }

    public function render()
    {
        $estaments = Estament::orderBy('id')->get();
        $areas = Area::orderBy('id')->get();
        $contractualConditions = ContractualCondition::orderBy('id')->get();

        return view('livewire.job-position-profile.create-job-position-profiles', 
            compact('estaments', 'areas', 'contractualConditions'));
    }

    public function updatedSelectedContractualCondition($selectedContractualConditionId)
    {
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
        }
    }

    public function updatedSelectedLaw($selectedLaw)
    {
        if($selectedLaw == 18834){
            $this->lawStateOption = 'disabled';
        }
        else{
            $this->lawStateOption = '';
        }
    }
}

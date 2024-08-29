<?php

namespace App\Livewire\JobPositionProfile;

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

    public $lawStateOption;

    public $workingDayState;

    public $action;

    public $jobPositionProfile;

    public $areas;
    public $areaSelected = null;

    public function mount(){
        if($this->jobPositionProfile){
            $this->selectedContractualCondition = $this->jobPositionProfile->contractual_condition_id;
            $this->updatedSelectedContractualCondition($this->selectedContractualCondition);

            $this->selectedLaw = $this->jobPositionProfile->law;
            $this->updatedSelectedLaw($this->selectedLaw);

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
        if($selectedContractualConditionId == '2'){
            $this->selectedLaw = null;
            $this->lawStateOption = 'disabled';
            $this->degree = null;
            $this->degreeStateInput = 'readonly';
            $this->salaryStateInput = null;
        }
        else{
            $this->lawStateOption = null;
        }
       
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

            $this->workingDayState = 'disabled';
        }
        else{
            //SE INHABILITA SALARIO Y GRADO
            $this->salaryStateInput = '';
            $this->salaryStateInput = 'readonly';
            $this->degreeStateInput = '';
            $this->degreeStateInput = 'readonly';

            //HORAS DISPONIBLES
            $this->workingDayState = null;
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
            $this->areas = Area::whereIn('id', [2,5,6])
                ->orderBy('id')
                ->get();
        }
        //PROFESIONAL
        if($selectedEstamentId == 3){
            $this->areas = Area::whereIn('id', [2,3,4])
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

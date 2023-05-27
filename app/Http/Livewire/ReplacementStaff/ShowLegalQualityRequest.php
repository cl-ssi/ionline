<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\LegalQualityManage;
use App\Models\ReplacementStaff\FundamentLegalQuality;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\RequestReplacementStaff;

class ShowLegalQualityRequest extends Component
{
    public $selectedLegalQuality = null;
    public $salaryStateInput = 'readonly';
    public $fundamentLegalQualities = null;

    public $selectedFundament = null;
    public $detailFundaments = null;

    public $selectedFundamentDetail = null;
    public $otherFundamentInput = 'readonly';
    //public $detailFundaments = null;

    public $requestReplacementStaff;
    
    public $formType;

    /* Para editar y precargar los select */
    public $legalQualitySelected = null;
    public $fundamentSelected = null;
    public $fundamentDetailSelected = null;

    /* PERFIL GRADO */
    public $selectedProfile = null;
    public $selectedDegree = null;

    public $degree = null;
    public $salary = null;
    public $degreeStateInput = 'readonly';

    /* Para editar y precargar el select PERFIL */
    public $profileSelected = null;

    public $isDisabled = '';
    public $editModePosition = false;

    protected $listeners = ['setPosition', 'setIsDisabled'];

    public $disabledNameToReplace = ''; 

    public function setInputsRequestReplacementStaff()
    {
        if($this->requestReplacementStaff) {
            $this->selectedLegalQuality = $this->requestReplacementStaff->legal_quality_manage_id;
            $this->selectedFundament = $this->requestReplacementStaff->fundament_manage_id;
            $this->degree = $this->requestReplacementStaff->degree;
            $this->salary = $this->requestReplacementStaff->salary;
            $this->fundamentLegalQualities = FundamentLegalQuality::where('legal_quality_manage_id', $this->selectedLegalQuality)
            ->where($this->formType, 1)
            ->get();
            
            if($this->selectedLegalQuality == 2){
                $this->salaryStateInput = '';
            }
            else{
                $this->salaryStateInput = 'disabled';
            }
            
            if($this->formType == 'announcement' && $this->selectedLegalQuality == 1){
                $this->degreeStateInput = '';
            }else{
                $this->degreeStateInput = 'readonly';
            }

            $this->selectedFundamentDetail = $this->requestReplacementStaff->fundament_detail_manage_id;

            $this->detailFundaments = RstDetailFundament::where('fundament_manage_id', $this->selectedFundament)
                ->where($this->formType, 1)
                ->get();

            if($this->selectedFundament == 4){
                $this->otherFundamentInput  = '';
                $this->emit('disabledRunDv');
            }
            else{
                $this->emit('enableRunDv');
            }

            /* PERFIL GRADO */
            $this->selectedProfile = $this->requestReplacementStaff->profile_manage_id;
            // if($this->formType == 'announcement' && $this->selectedLegalQuality == 1) $this->degreeStateInput = '';
            if($this->formType == 'replacement')
                switch ($this->requestReplacementStaff->profile_manage_id) {
                    case 1:
                        $this->degree = '22';
                        break;
                    case 2:
                        $this->degree = '24';
                        break;
                    case 3:
                        $this->degree = '16';
                        break;
                    case 4:
                        $this->degree = '22';
                        break;

                    case '':
                        $this->degree = '';
                        break;
                }
        }
    }

    public function mount(){
        $this->setInputsRequestReplacementStaff();
    }

    public function render(){
        
        return view('livewire.replacement-staff.show-legal-quality-request',[
            'legal_qualities' => LegalQualityManage::
                where($this->formType, 1)
                ->get(),

            'profiles' => ProfileManage::orderBy('name', 'ASC')->get(),
            'disabledNameToReplace' => $this->disabledNameToReplace
        ]);
    }

    public function updatedselectedLegalQuality($selected_legal_quality_id){
        if($this->editModePosition) $this->legalQualitySelected = $selected_legal_quality_id;
        $this->selectedProfile = null;
        $this->degree = null;
        $this->fundamentLegalQualities = FundamentLegalQuality::where('legal_quality_manage_id', $selected_legal_quality_id)
        ->where($this->formType, 1)
        ->get();
        
        if($selected_legal_quality_id == 2){
            $this->salaryStateInput = '';
        }
        else{
            $this->salaryStateInput = 'disabled';
        }
        
        if($this->formType == 'announcement' && $selected_legal_quality_id == 1) 
            $this->degreeStateInput = '';
        else
            $this->degreeStateInput = 'readonly';
    }

    public function updatedselectedFundament($selected_fundament_id){
        if($this->editModePosition) $this->fundamentSelected = $selected_fundament_id;
        $this->detailFundaments = RstDetailFundament::where('fundament_manage_id', $selected_fundament_id)
            ->where($this->formType, 1)
            ->get();

        if($selected_fundament_id == 4){
            $this->otherFundamentInput = '';
            $this->emit('disabledRunDv');
            $this->emit('disabledNameToReplace');
        }
        else{
            $this->emit('enableRunDv');
            $this->emit('enableNameToReplace');
        }
    }

    public function updatedselectedProfile($profile_id){
        if($this->editModePosition) $this->profileSelected = $profile_id;
        if($this->formType == 'replacement')
            switch ($profile_id) {
                case 1:
                    $this->degree = '22';
                    break;
                case 2:
                    $this->degree = '24';
                    break;
                case 3:
                    $this->degree = '16';
                    break;
                case 4:
                    $this->degree = '22';
                    break;

                case '':
                    $this->degree = '';
                    break;
            }
    }

    public function setPosition($position)
    {
        $this->isDisabled = '';
        $this->editModePosition = true;
        $this->requestReplacementStaff = new RequestReplacementStaff();
        $this->requestReplacementStaff->fill($position);
        // dd($this->requestReplacementStaff);
        $this->setInputsRequestReplacementStaff();
    }

    public function setIsDisabled($value)
    {
        $this->isDisabled = $value;
    }
}

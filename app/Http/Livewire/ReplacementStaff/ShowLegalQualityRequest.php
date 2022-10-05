<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\LegalQualityManage;
use App\Models\ReplacementStaff\FundamentLegalQuality;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\ProfileManage;

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

    /* Para editar y precargar el select PERFIL */
    public $profileSelected = null;

    public function mount(){
        if($this->requestReplacementStaff) {
            $this->selectedLegalQuality = $this->requestReplacementStaff->legal_quality_manage_id;
            $this->selectedFundament = $this->requestReplacementStaff->fundament_manage_id;

            $this->fundamentLegalQualities = FundamentLegalQuality::where('legal_quality_manage_id', $this->selectedLegalQuality)
                ->where($this->formType, 1)
                ->get();

            if($this->selectedFundament == 2){
                $this->salaryStateInput = '';
            }
            else{
                $this->salaryStateInput = 'disabled';
            }

            $this->selectedFundamentDetail = $this->requestReplacementStaff->fundament_detail_manage_id;

            $this->detailFundaments = RstDetailFundament::where('fundament_manage_id', $this->selectedFundament)
                ->where($this->formType, 1)
                ->get();

            if($this->selectedFundamentDetail == 4){
                $this->otherFundamentInput = '';
            }

            /* PERFIL GRADO */
            $this->selectedProfile = $this->requestReplacementStaff->profile_manage_id;
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

    public function render(){
        
        return view('livewire.replacement-staff.show-legal-quality-request',[
            'legal_qualities' => LegalQualityManage::
                where($this->formType, 1)
                ->get(),

            'profiles' => ProfileManage::orderBy('name', 'ASC')->get()
        ]);
    }

    public function updatedselectedLegalQuality($selected_legal_quality_id){
        $this->fundamentLegalQualities = FundamentLegalQuality::where('legal_quality_manage_id', $selected_legal_quality_id)
            ->where($this->formType, 1)
            ->get();

        if($selected_legal_quality_id == 2){
            $this->salaryStateInput = '';
        }
        else{
            $this->salaryStateInput = 'disabled';
        }
    }

    public function updatedselectedFundament($selected_fundament_id){
        $this->detailFundaments = RstDetailFundament::where('fundament_manage_id', $selected_fundament_id)
            ->where($this->formType, 1)
            ->get();

        if($selected_fundament_id == 4){
            $this->otherFundamentInput = '';
        }
    }

    public function updatedselectedProfile($profile_id){
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
}

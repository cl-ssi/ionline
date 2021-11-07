<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\LegalQualityManage;
use App\Models\ReplacementStaff\FundamentLegalQuality;
use App\Models\ReplacementStaff\RstDetailFundament;

class ShowLegalQualityRequest extends Component
{
    public $selectedLegalQuality = null;
    public $salaryStateInput = 'readonly';
    public $fundamentLegalQualities = null;

    public $selectedFundament = null;
    public $detailFundaments = null;

    public $requestReplacementStaff;

    public function render()
    {
        return view('livewire.replacement-staff.show-legal-quality-request',[
            'legal_qualities' => LegalQualityManage::all()
        ]);
    }

    public function updatedselectedLegalQuality($selected_legal_quality_id){
        $this->fundamentLegalQualities = FundamentLegalQuality::where('legal_quality_manage_id', $selected_legal_quality_id)->get();

        if($selected_legal_quality_id == 2){
            $this->salaryStateInput = '';
        }
        else{
            $this->salaryStateInput = 'disabled';
        }
    }

    public function updatedselectedFundament($selected_fundament_id){
        $this->detailFundaments = RstDetailFundament::where('fundament_manage_id', $selected_fundament_id)->get();
    }
}

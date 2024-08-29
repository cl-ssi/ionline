<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ReplacementStaff;
//use Livewire\WithPagination;

class SearchSelectApplicants extends Component
{
    //use WithPagination;

    public $technicalEvaluation;
    public $professionManage = null;

    public $selectedProfile = null;
    public $selectedSearch = null;
    public $selectedProfession = null;
    public $selectedStaff = null;

    public function render()
    {
        return view('livewire.replacement-staff.search-select-applicants',[
            'profileManage' => ProfileManage::orderBy('name', 'ASC')->get(),
            //'professionManage' => ProfessionManage::orderBy('name', 'ASC')->get(),
            'replacementStaff' => ReplacementStaff::
                orderBy('updated_at', 'DESC')
                ->search($this->selectedSearch,$this->selectedProfile,$this->selectedProfession,$this->selectedStaff, 0)
                ->whereNotIn('status', ['selected'])
                ->take(10)
                ->get()
        ]);
    }

    public function updatedselectedProfile($profile_id){
        $this->professionManage = ProfessionManage::where('profile_manage_id', $profile_id)->OrderBy('name')->get();
    }
}

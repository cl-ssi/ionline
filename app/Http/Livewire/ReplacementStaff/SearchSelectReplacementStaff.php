<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ReplacementStaff;

class SearchSelectReplacementStaff extends Component
{
    // public $technicalEvaluation;
    public $professionManage = null;

    public $selectedProfile = null;
    public $selectedSearch = null;
    public $selectedProfession = null;

    public function render()
    {
        return view('livewire.replacement-staff.search-select-replacement-staff',[
            'profileManage' => ProfileManage::orderBy('name', 'ASC')->get(),
            //'professionManage' => ProfessionManage::orderBy('name', 'ASC')->get(),
            'replacementStaff' => ReplacementStaff::latest()
                ->search($this->selectedSearch,$this->selectedProfile,$this->selectedProfession)
                ->whereNotIn('status', ['selected'])
                ->take(10)
                ->get()
        ]);
        // return view('livewire.replacement-staff.search-select-replacement-staff');
    }

    public function updatedselectedProfile($profile_id){
        $this->professionManage = ProfessionManage::where('profile_manage_id', $profile_id)->OrderBy('name')->get();
    }
}

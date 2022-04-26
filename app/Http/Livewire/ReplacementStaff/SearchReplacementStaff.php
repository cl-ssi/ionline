<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ReplacementStaff;

class SearchReplacementStaff extends Component
{
    public $professionManage = null;

    public $selectedProfile = null;
    public $selectedSearch = null;
    public $selectedProfession = null;
    public $selectedStaff = null;
    public $selectedStatus = null;

    public function render()
    {
        return view('livewire.replacement-staff.search-replacement-staff', [
            'profileManage' => ProfileManage::orderBy('name', 'ASC')->get(),
            'replacementStaff' => ReplacementStaff::latest()
                ->search($this->selectedSearch, $this->selectedProfile, $this->selectedProfession, $this->selectedStaff, $this->selectedStatus)
                ->take(50)
                ->get()
        ]);
    }

    public function updatedselectedProfile($profile_id){
        $this->professionManage = ProfessionManage::where('profile_manage_id', $profile_id)
            ->OrderBy('name')
            ->get();
    }
}

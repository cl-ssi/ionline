<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

use App\Models\ReplacementStaff\ProfessionManage;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\ReplacementStaff;
use Livewire\WithPagination;

class SearchReplacementStaff extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $professionManage = null;

    public $selectedProfile = null;
    public $selectedSearch = null;
    public $selectedProfession = null;
    public $selectedStaff = null;
    public $selectedStatus = 0;

    public function render()
    {
        return view('livewire.replacement-staff.search-replacement-staff', [
            'profileManage' => ProfileManage::orderBy('name', 'ASC')->get(),
            'replacementStaff' => ReplacementStaff::
                with(['profiles', 'profiles.profile_manage', 'profiles.profession_manage'])
                ->latest()
                ->search($this->selectedSearch, 
                    $this->selectedProfile, 
                    $this->selectedProfession, 
                    $this->selectedStaff, 
                    $this->selectedStatus)
                ->paginate(50)
        ]);
    }

    public function updatedselectedProfile($profile_id){
        $this->professionManage = ProfessionManage::where('profile_manage_id', $profile_id)
            ->OrderBy('name')
            ->get();
    }
}

<?php

namespace App\Livewire\ReplacementStaff;

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

    public $selectedSearch = null;
    public $selectedProfile = null;
    public $selectedProfession = null;
    public $selectedStaff = null;
    public $selectedStatus = 0;

    public $profileId = null;

    protected $queryString = ['selectedSearch', 
        'selectedProfile',
        'selectedProfession',
        'selectedStaff', 
        'selectedStatus' => ['except' => 0]
    ];

    public function render()
    {
        return view('livewire.replacement-staff.search-replacement-staff', [
            'profileManage' => ProfileManage::orderBy('name', 'ASC')->get(),
            'replacementStaff' => ReplacementStaff::
                with(['profiles', 'profiles.profile_manage', 'profiles.profession_manage'])
                ->orderBy('updated_at', 'DESC')
                ->search($this->selectedSearch, 
                    $this->selectedProfile, 
                    $this->selectedProfession, 
                    $this->selectedStaff, 
                    $this->selectedStatus)
                ->paginate(50)
        ]);
    }

    public function updatedselectedProfile($profile_id){
        //$this->profileId = $profile_id;

        $this->professionManage = ProfessionManage::where('profile_manage_id', $profile_id)
            ->OrderBy('name')
            ->get();
    }

    /* Permite alamcenar parámetros de búsqueda con paginación */
    public function updatingSelectedSearch(){
        $this->resetPage();
    }

    public function updatingSelectedProfile(){
        $this->resetPage();
    }

    public function updatingSelectedProfession(){
        $this->resetPage();
    }

    public function updatingSelectedStaff(){
        $this->resetPage();
    }

    public function updatingSelectedStatus(){
        $this->resetPage();
    }

    public function clearForm(){
        $this->selectedSearch = null;
        $this->selectedProfile = null;
        $this->selectedProfession = null;
        $this->selectedStaff = null;
        $this->selectedStatus = 0;
    }

    public function mount(){
        // $this->professionManage = ProfessionManage::where('profile_manage_id', $this->profileId)
        //     ->OrderBy('name')
        //     ->get();
        $this->updatedselectedProfile($this->profileId);
    }
}

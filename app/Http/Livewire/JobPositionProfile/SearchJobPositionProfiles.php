<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Support\Facades\Auth;

class SearchJobPositionProfiles extends Component
{
    public $index;

    public function render()
    {
        if($this->index == 'own'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    latest()
                    ->Where('user_creator_id', Auth::user()->id)
                    ->orWhere('ou_creator_id', Auth::user()->organizationalUnit->id)
                    // ->search($this->selectedStatus,
                    //     $this->selectedId,
                    //     $this->selectedUserAllowance)
                    ->paginate(50)
            ]);
        }

        if($this->index == 'review'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    latest()
                    ->Where('status', 'review')
                    ->paginate(50)
            ]);
        }
    }
}

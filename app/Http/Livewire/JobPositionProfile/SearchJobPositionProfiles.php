<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Support\Facades\Auth;

use App\Rrhh\Authority;

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

        if($this->index == 'to_sign'){
            $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', Auth::user()->id);
            $iam_authorities_in = array();

            foreach ($authorities as $authority){
                $iam_authorities_in[] = $authority->organizational_unit_id;
            }

            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                        'user')
                    ->whereHas('jobPositionProfileSigns', function($q) use ($iam_authorities_in){
                        $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                        ->Where('status', 'pending');
                    })
                    ->paginate(50),
                'reviewedJobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                        'user')
                    ->whereHas('jobPositionProfileSigns', function($q) use ($iam_authorities_in){
                        $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                        ->Where(function ($j){
                            $j->Where('status', 'accepted')
                            ->OrWhere('status', 'rejected');
                        });
                    })
                    ->paginate(50)
            ]);
        }
    }
}

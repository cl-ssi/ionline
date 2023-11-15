<?php

namespace App\Http\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use App\Rrhh\Authority;
use App\Models\Parameters\Estament;

class SearchJobPositionProfiles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $index;

    public $selectedStatus      = null;
    public $selectedEstament    = null;

    protected $queryString = ['selectedStatus', 'selectedEstament'];

    public function render()
    {
        if($this->index == 'own'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                        'user', 'estament', 'area', 'contractualCondition')
                    ->latest()
                    ->Where('user_creator_id', Auth::user()->id)
                    ->orWhere('jpp_ou_id', Auth::user()->organizationalUnit->id)
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
                        'user', 'estament', 'area', 'contractualCondition')
                    ->whereHas('jobPositionProfileSigns', function($q) use ($iam_authorities_in){
                        $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                        ->Where('status', 'pending');
                    })
                    ->paginate(50),
                'reviewedJobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                        'user', 'estament', 'area', 'contractualCondition')
                    ->whereHas('jobPositionProfileSigns', function($q) use ($iam_authorities_in){
                        $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                        ->Where(function ($j){
                            $j->Where('status', 'accepted')
                            ->OrWhere('status', 'rejected');
                        });
                    })
                    ->paginate(50),
            ]);
        }

        if($this->index == 'all'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                    'user', 'estament', 'area', 'contractualCondition')
                    ->latest()
                    ->search($this->selectedStatus,
                    $this->selectedEstament)
                    ->paginate(50),
                'estaments' => Estament::orderBy('id')->get()
            ]);
        }
    }

    /* Permite alamcenar parámetros de búsqueda con paginación */
    public function updatingSelectedStatus(){
        $this->resetPage();
    }

    public function updatingSelectedEstament(){
        $this->resetPage();
    }
}

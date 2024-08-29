<?php

namespace App\Livewire\JobPositionProfile;

use Livewire\Component;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use App\Models\Rrhh\Authority;
use App\Models\Parameters\Estament;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Parameter;

class SearchJobPositionProfiles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $index;

    public $selectedStatus      = null;
    public $selectedEstament    = null;
    public $selectedId          = null;  
    public $selectedUserCreator = null;
    public $selectedName        = null;
    public $ou_dependents_array = [];
    public $selectedSub = null;

    protected $queryString = ['selectedStatus', 'selectedEstament', 'selectedId', 'selectedUserCreator', 'selectedSub'];

    public function render()
    {
        if($this->index == 'own'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                        'user', 'estament', 'area', 'contractualCondition')
                    ->latest()
                    ->Where('user_creator_id', auth()->id())
                    ->orWhere('jpp_ou_id', auth()->user()->organizationalUnit->id)
                    ->orWhere('ou_creator_id', auth()->user()->organizationalUnit->id)
                    ->search($this->selectedStatus,
                        $this->selectedEstament,
                        $this->selectedId,
                        $this->selectedName,
                        $this->selectedUserCreator,
                        $this->ou_dependents_array)
                    ->paginate(50),
                'estaments' => Estament::orderBy('id')->get()
            ]);
        }

        if($this->index == 'review'){
            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    latest()
                    ->Where('status', 'review')
                    ->paginate(50),
                'estaments' => Estament::orderBy('id')->get()
            ]);
        }

        if($this->index == 'to_sign'){
            $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', auth()->id());
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
                'estaments' => Estament::orderBy('id')->get()
            ]);
        }

        if($this->index == 'all'){
            $subParams = Parameter::select('value')
                ->whereIn('parameter', ['SubRRHH', 'SDASSI', 'SubSDGA'])
                ->get()
                ->toArray();

            return view('livewire.job-position-profile.search-job-position-profiles', [
                'jobPositionProfiles' => JobPositionProfile::
                    with('organizationalUnit', 'jobPositionProfileSigns', 'jobPositionProfileSigns.organizationalUnit',
                    'user', 'estament', 'area', 'contractualCondition')
                    ->latest()
                    ->search($this->selectedStatus,
                        $this->selectedEstament,
                        $this->selectedId,
                        $this->selectedName,
                        $this->selectedUserCreator,
                        $this->ou_dependents_array)
                    ->paginate(50),
                'estaments' => Estament::orderBy('id')->get(),
                'subs' => OrganizationalUnit::whereIn('id', $subParams)->get()
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

    public function updatingSelectedId(){
        $this->resetPage();
    }

    public function updatingSelectedUserCreator(){
        $this->resetPage();
    }

    public function updatingSelectedSub(){
        $this->resetPage();
    }

    public function updatedselectedSub($sub_id)
    {
        $this->ou_dependents_array = [];
        $ou_dependents = collect(new OrganizationalUnit);

        $ou_dependents = OrganizationalUnit::
            where('organizational_unit_id', $sub_id)
            ->get();
            
        foreach($ou_dependents as $ou_dependent){
            $ou_dependent_childs = OrganizationalUnit::
                where('organizational_unit_id', $ou_dependent->id)
                ->get();
            
            foreach($ou_dependent_childs as $ou_dependent_child){
                $ou_dependents->push($ou_dependent_child);
            }
        }
        
        foreach($ou_dependents as $ou_dependent){
            $this->ou_dependents_array[] = $ou_dependent->id;
        }
    }
}

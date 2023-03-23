<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Parameter;

class SearchRequests extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedStatus          = null;
    public $selectedId              = null;  
    public $selectedStartDate       = null;
    public $selectedEndDate         = null;
    public $selectedName            = null;
    public $selectedFundament       = null;
    public $selectedFundamentDetail = null;
    public $selectedNameToReplace   = null;
    public $selectedSub             = null;
    public $ou_dependents_array     = [];

    public $fundamentsDetail;

    public $typeIndex;
    public $request;

    public function render()
    {   
        if($this->typeIndex == 'assign'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign', 'requesterUser', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->latest()
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace,
                    $this->ou_dependents_array
                )
                ->paginate(50);
        }

        if($this->typeIndex == 'own'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign', 'requesterUser', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])   
                ->latest()
                ->where('user_id', Auth::user()->id)
                ->orWhere('requester_id', Auth::user()->id)
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace,
                    $this->ou_dependents_array
                )
                ->paginate(50);
        }

        if($this->typeIndex == 'ou'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign', 'requesterUser', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->latest()
                ->where('user_id', Auth::user()->id)
                ->orWhere('requester_id', Auth::user()->id)
                ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id)
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace,
                    $this->ou_dependents_array
                )
                ->paginate(50);
        }

        if($this->typeIndex == 'personal'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign', 'requesterUser', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->latest()
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace,
                    $this->ou_dependents_array
                )
                ->paginate(50);
        }

        if($this->typeIndex == 'assigned_to'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign', 'requesterUser', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->WhereHas('assignEvaluations', function($j) {
                    $j->Where('to_user_id', Auth::user()->id)
                    ->where('status', 'assigned');
                })
                ->latest()
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace,
                    $this->ou_dependents_array
                )
                ->paginate(50);
        }

        $subParams = Parameter::
            select('value')
            ->whereIn('parameter', ['SubRRHH', 'SDASSI', 'SubSDGA'])
            ->get()
            ->toArray();

        $subs = OrganizationalUnit::whereIn('id', $subParams)->get();

        return view('livewire.replacement-staff.search-requests',[
            'fundaments'    => RstFundamentManage::all(),
            'requests'      => $requests,
            'users_rys'     => User::where('organizational_unit_id', 48)->get(),
            'subs'          => $subs
        ]);
    }

    public function updatedselectedFundament($fundament_id)
    {
        $this->fundamentsDetail = RstDetailFundament::
            where('fundament_manage_id', $fundament_id)->get();
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

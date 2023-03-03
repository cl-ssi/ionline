<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\User;

class SearchRequests extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedStatus = null;
    public $selectedId = null;
    public $selectedStartDate = null;
    public $selectedEndDate = null;
    public $selectedName = null;
    public $selectedFundament = null;
    public $selectedFundamentDetail = null;
    public $selectedNameToReplace = null;

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
                    $this->selectedNameToReplace
                )
                ->paginate(50);

            // $pending_requests = RequestReplacementStaff::latest()
            //     ->where('request_status', 'pending')
            //     ->where(function ($q){
            //         $q->doesntHave('technicalEvaluation')
            //     ->orWhereHas('technicalEvaluation', function( $query ) {
            //       $query->where('technical_evaluation_status','pending');
            //     });
            // })
            // ->get();
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
                    $this->selectedNameToReplace
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
                    $this->selectedNameToReplace
                )
                ->paginate(50);
        }

        return view('livewire.replacement-staff.search-requests',[
            'fundaments' => RstFundamentManage::all(),
            'requests' => $requests,
            'users_rys' => User::where('organizational_unit_id', 48)->get()
        ]);
    }

    public function updatedselectedFundament($fundament_id)
    {
        $this->fundamentsDetail = RstDetailFundament::
            where('fundament_manage_id', $fundament_id)->get();
    }

    
}

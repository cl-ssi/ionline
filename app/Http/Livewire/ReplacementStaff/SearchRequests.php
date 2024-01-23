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

use App\Models\ReplacementStaff\AssignEvaluation;
use App\Models\ReplacementStaff\TechnicalEvaluation;

class SearchRequests extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedFormType        = null;
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
    public $selectedAssigned        = null;

    public $selectedFundamentInputStatus = '';
    public $selectedFundamentDetailInputStatus = '';

    public $fundamentsDetail;

    public $typeIndex;
    public $request;

    public $userToAssign = null;
    public $checkToAssign = [];

    public function render()
    {   
        if($this->typeIndex == 'assign'){
            /*
            if($this->selectedAssigned == 'yes'){
                $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage', 
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->whereHas('technicalEvaluation')
                ->latest()
                ->search($this->selectedFormType,
                    $this->selectedStatus,
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
            */

            if($this->selectedAssigned == ''){
                $requests = RequestReplacementStaff::
                    with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage', 
                        'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                        'assignEvaluations'])
                    ->latest()
                    ->search($this->selectedFormType,
                        $this->selectedStatus,
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

            if($this->selectedAssigned == 'no'){
                $requests = RequestReplacementStaff::
                    with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage', 
                        'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                        'assignEvaluations'])
                    ->whereDoesntHave('technicalEvaluation')
                    ->where('request_status', 'to assign')
                    ->latest()
                    ->search($this->selectedFormType,
                        $this->selectedStatus,
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
        }

        if($this->typeIndex == 'own'){
            $requests = RequestReplacementStaff::
                with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage',
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])   
                ->latest()
                ->where('user_id', Auth::user()->id)
                ->orWhere('requester_id', Auth::user()->id)
                ->search($this->selectedFormType,
                    $this->selectedStatus,
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
                with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage',
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->latest()
                ->where('user_id', Auth::user()->id)
                ->orWhere('requester_id', Auth::user()->id)
                ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id)
                ->search($this->selectedFormType,
                    $this->selectedStatus,
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
                with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage',
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations'])
                ->latest()
                ->search($this->selectedFormType,
                    $this->selectedStatus,
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
                with(['user', 'organizationalUnit', 'requestSign.organizationalUnit', 'requesterUser', 'profile_manage',
                    'legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'technicalEvaluation',
                    'assignEvaluations.userAssigned'])
                ->WhereHas('assignEvaluations', function($j) {
                    $j->Where('to_user_id', Auth::user()->id)
                    ->where('status', 'assigned');
                })
                ->latest()
                ->search($this->selectedFormType,
                    $this->selectedStatus,
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

    public function updatedselectedFormType($form_type_id)
    {
        if($form_type_id == 'announcement'){
            $this->selectedFundamentInputStatus = 'disabled';
            $this->selectedFundamentDetailInputStatus = 'disabled';
        }
        else{
            $this->selectedFundamentInputStatus = '';
            $this->selectedFundamentDetailInputStatus = '';
        }
    }

    protected function messages(){
        return [
            /* Mensajes para asignación */
            'userToAssign.required'    => 'Debe ingresar funcionario para asignar solicitud.',
            'checkToAssign.required'   => 'Debe seleccionar una solicitud para asignar.'
        ];
    }

    public function assign(){
        $validatedData = $this->validate([
            'userToAssign'  => 'required',
            'checkToAssign' => 'required'
        ]);

        foreach($this->checkToAssign as $key_file => $id){
            $request = RequestReplacementStaff::find($id);

            $assign_evaluation = new AssignEvaluation();
            $assign_evaluation->user()->associate(Auth::user());
            $assign_evaluation->to_user_id = $this->userToAssign;
            $assign_evaluation->requestReplacementStaff()->associate($request);
            $assign_evaluation->status = 'assigned';
            $assign_evaluation->save();

            $technicalEvaluation = new TechnicalEvaluation();
            $technicalEvaluation->technical_evaluation_status = 'pending';
            $technicalEvaluation->user()->associate(Auth::user());
            $technicalEvaluation->organizational_unit_id = Auth::user()->organizationalUnit->id;
            $technicalEvaluation->request_replacement_staff_id = $request->id;
            $technicalEvaluation->save();
        }

        session()->flash('success', 'Se ha asignado exitosamente el Proceso de Selección');
        return redirect()->route('replacement_staff.request.index');
    }
}

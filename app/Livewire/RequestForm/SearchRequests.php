<?php

namespace App\Livewire\RequestForm;

use App\Exports\RequestForms\RequestFormsExport;
use App\Models\Parameters\Parameter;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\User;
use Carbon\Carbon;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rrhh\OrganizationalUnit;
use App\Exports\RequestForms\FormItemsExport;
use App\Models\Parameters\PurchaseMechanism;

class SearchRequests extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedStatus = null;
    public $selectedStatusPurchase = null;
    public $selectedId = null;
    public $selectedFolio = null;
    public $selectedName = null;
    public $selectedStartDate = null;
    public $selectedEndDate = null;
    public $selectedRequester = null;
    public $selectedRequesterOuName = null;
    public $selectedAdmin = null;
    public $selectedAdminOuName = null;
    public $selectedPurchaser = null;
    public $selectedProgram = null;
    public $selectedPo = null;
    public $selectedTender = null;
    public $selectedSupplier = null;
    public $selectedSubtype = null;
    public $result = null;
    public $inbox;
    public $type;

    // public $batchId;
    // public $exporting = false;
    // public $exportFinished = false;

    public $organizationalUnit;

    //SEARCH FORM-ITEMS
    // public $activeSearch = false;
    public $lstPurchaseMechanism;
    public $selectedPurchaseMechanism = null;

    protected $queryString = ['selectedStatus', 'selectedStatusPurchase', 'selectedId', 'selectedFolio',
        'selectedName', 'selectedStartDate', 'selectedEndDate', 'selectedRequester', 'selectedRequesterOuName',
        'selectedAdmin', 'selectedAdminOuName', 'selectedPurchaser', 'selectedProgram', 'selectedPo', 'selectedSupplier', 'selectedSubtype',
        'selectedPurchaseMechanism'
    ];

    public function mount() {
        if ($this->inbox == 'purchase' && $this->selectedStatusPurchase == null) {
            $this->selectedStatusPurchase = 'in_process';
        }
    }

    public function querySearch($isPaginated = true)
    {
        $query = RequestForm::query();

        if(auth()->user()->organizationalUnit->establishment->id == Parameter::get('establishment', 'HETG')){
            $query->whereHas('userOrganizationalUnit', function ($q){
                return $q->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);
            })
            ->orWhereHas('contractOrganizationalUnit', function ($q){
                return $q->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);
            });
        }

        if($this->inbox == 'own'){
            $query->where('request_user_id', auth()->id())
                ->OrWhere('request_user_ou_id', auth()->user()->OrganizationalUnit->id);
        }

        if($this->inbox == 'contract manager'){
            $query->where('contract_manager_id', auth()->id());
        }

        if($this->inbox == 'all' || $this->inbox == 'report: form-items'){
            // Filtro por Hospital Alto Hospicio + Unidad Puesta en marcha HAH
            // if(auth()->user()->organizationalUnit->establishment->id == Parameter::where('parameter', 'HospitalAltoHospicio')->first()->value){
            if(auth()->user()->organizationalUnit->establishment->id == Parameter::get('establishment', 'HospitalAltoHospicio')){
                // $ouSearch = Parameter::where('parameter', 'PuestaEnMarchaHAH')->first()->value;
                $ouSearch = Parameter::get('ou', 'PuestaEnMarchaHAH');
                $query->whereHas('userOrganizationalUnit', function ($q) use ($ouSearch) {
                    return $q->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                    ->orWhere('request_user_ou_id', $ouSearch);
                })
                ->orWhereHas('contractOrganizationalUnit', function ($q) use ($ouSearch) {
                    return $q->where('establishment_id', auth()->user()->organizationalUnit->establishment_id)
                    ->orWhere('contract_manager_ou_id', $ouSearch);
                });
            }
            else{
                $query->whereHas('contractOrganizationalUnit', function ($q) {
                    return $q->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);
                });
            }
        }

        if($this->inbox == 'purchase'){            
            $query->where('status', 'approved')->whereNotNull('signatures_file_id')
                ->whereHas('purchasers', function ($q) {
                    return $q->where('users.id', auth()->user()->id);
                })
                ->latest('approved_at');
        }

        $query->search($this->selectedStatus,
        $this->selectedStatusPurchase,
        $this->selectedId,
        $this->selectedFolio,
        $this->selectedName,
        $this->selectedStartDate,
        $this->selectedEndDate,
        $this->selectedRequester,
        $this->selectedRequesterOuName,
        $this->selectedAdmin,
        $this->selectedAdminOuName,
        $this->selectedPurchaser,
        $this->selectedProgram,
        $this->selectedPo,
        $this->selectedTender,
        $this->selectedSupplier,
        $this->selectedSubtype,
        $this->selectedPurchaseMechanism
        );

        if($this->inbox == 'report: form-items'){
            $this->lstPurchaseMechanism   = PurchaseMechanism::all();

            if($this->type == 'items'){
                $query->with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'purchaseType','associateProgram', 'purchasingProcess.details', 
                    'itemRequestForms.product', 'itemRequestForms.budgetItem','father:id,folio,has_increased_expense', 'purchasers', 'purchasingProcess')
                    ->doesntHave('passengers');
                    /*
                    ->select(['id', 'status', 'folio', 'created_at', 'subtype', 'name', 'type_of_currency', 'estimated_expense',
                    'approved_at']);
                    */
            }else{ // pasajes aereos
                $query->with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'purchaseType','associateProgram', 'purchasingProcess.detailsPassenger', 
                'passengers', 'passengers.budgetItem','father:id,folio,has_increased_expense', 'purchasers', 'purchasingProcess')
                ->doesntHave('itemRequestForms');
            }
        }else{
            $query->with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'purchaseType', 'eventRequestForms.signerUser',
            'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'purchasers', 'purchasingProcess');
        }

        $query->latest();

        return ($isPaginated) ? $query->paginate(50) : $query->cursor();
    }

    public function render()
    {   
        // $ouSearch = Parameter::where('module', 'ou')->whereIn('parameter', ['AbastecimientoSSI', 'AdquisicionesHAH'])->pluck('value')->toArray();
        $estab_hetg = Parameter::get('establishment', 'HETG');
        if(auth()->user()->organizationalUnit->establishment->id == Parameter::get('establishment', 'HETG')){
            $ouSearch = Parameter::get('Abastecimiento','purchaser_ou_id', $estab_hetg);
            $users = User::permission('Request Forms: purchaser')->whereHas('organizationalUnit', fn($q) => $q->where('establishment_id', $estab_hetg))->OrWhere('organizational_unit_id', $ouSearch)->orderBy('name','asc')->get();
        }else{
            $estab_others = Parameter::get('establishment', ['SSTarapaca', 'HospitalAltoHospicio']);
            $ouSearch = Parameter::get('Abastecimiento','purchaser_ou_id', $estab_others);
            $users = User::permission('Request Forms: purchaser')->whereHas('organizationalUnit', fn($q) => $q->whereIn('establishment_id', $estab_others))->OrWhereIn('organizational_unit_id', $ouSearch)->orderBy('name','asc')->get();
        }

        return view('livewire.request-form.search-requests', [
            'request_forms' => $this->querySearch(),
            'users' => $users,
        ]);
    }

    public function export()
    {
        // $this->exporting = true;
        // $this->exportFinished = false;

        // $batch = Bus::batch([
        //     new ProcessReportFormItems($this->querySearch(false)),
        // ])->dispatch();

        // $this->batchId = $batch->id; 
        return Excel::download(new RequestFormsExport($this->querySearch(false)), 'requestFormsExport_'.Carbon::now().'.xlsx');
    }

    public function exportFormItems()
    {
        // $this->detailsToExport = collect(new ItemRequestForm);
        // foreach($this->querySearch(false) as $search){
        //     if($search->purchasingProcess && $search->purchasingProcess->details->count() > 0){
        //         foreach($search->purchasingProcess->details as $key => $detail){
        //             $this->detailsToExport->push($detail);
        //         }
        //     }
        // }

        //ProcessReportFormItems::dispatch($this->detailsToExport);
            // ->onConnection('cloudtasks')
            //->delay(15);
        // dd($this->querySearch(false));
        return Excel::download(new FormItemsExport($this->querySearch(false), $this->type), 'requestFormsExport_'.Carbon::now().'.xlsx');
        // $this->exporting = true;
        // $this->exportFinished = false;

        // $batch = Bus::batch([
        //     new ProcessReportFormItems($this->querySearch(false)),
        // ])->dispatch();

        // $this->batchId = $batch->id;   
    }

    // public function getExportBatchProperty()
    // {
    //     if (!$this->batchId) {
    //         return null;
    //     }

    //     return Bus::findBatch($this->batchId);
    // }

    // public function downloadExport()
    // {
    //     return Storage::download('public/requestFormsExport.xlsx');
    // }

    // public function updateExportProgress()
    // {
    //     $this->exportFinished = $this->exportBatch->finished();

    //     if ($this->exportFinished) {
    //         $this->exporting = false;
    //     }
    // }

    #[On('searchedRequesterOu')]
    public function searchedRequesterOu(OrganizationalUnit $organizationalUnit){
        $this->selectedRequesterOuName = $organizationalUnit->id;
    }

    #[On('clearRequesterOu')]
    public function clearRequesterOu(){
        $this->selectedRequesterOuName = null;
    }

    /**
     * Listener
     */
    #[On('searchedAdminOu')]
    public function searchedAdminOu(OrganizationalUnit $organizationalUnit){
        $this->selectedAdminOuName = $organizationalUnit->id;
    }

    #[On('clearAdminOu')]
    public function clearAdminOu(){
        $this->selectedAdminOuName = null;
    }

    //RESET PAGE
    public function updatingSelectedStatus(){
        $this->resetPage();
    }

    public function updatingSelectedStatusPurchase(){
        $this->resetPage();
    }

    public function updatingSelectedSubType(){
        $this->resetPage();
    }


    public function updatingSelectedId(){
        $this->resetPage();
    }

    public function updatingSelectedFolio(){
        $this->resetPage();
    }

    public function updatingName(){
        $this->resetPage();
    }

    public function updatingStartDate(){
        $this->resetPage();
    }

    public function updatingEndDate(){
        $this->resetPage();
    }

    public function updatingRequester(){
        $this->resetPage();
    }

    public function updatingRequesterOuName(){
        $this->resetPage();
    }

    public function updatingAdmin(){
        $this->resetPage();
    }

    public function updatingAdminOuName(){
        $this->resetPage();
    }

    public function updatingPurchaser(){
        $this->resetPage();
    }

    public function updatingProgram(){
        $this->resetPage();
    }

    public function updatingPo(){
        $this->resetPage();
    }

    public function updatingSupplier(){
        $this->resetPage();
    }

    public function updatingSelectedPurchaseMechanism(){
        $this->resetPage();
    }

    /*
    public function search(){
        $this->activeSearch = true;
    }
    */
}

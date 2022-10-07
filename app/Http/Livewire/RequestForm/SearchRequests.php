<?php

namespace App\Http\Livewire\RequestForm;

use App\Exports\RequestForms\RequestFormsExport;
use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\User;
use Carbon\Carbon;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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
    public $selectedAdmin = null;
    public $selectedPurchaser = null;
    public $selectedProgram = null;
    public $result = null;

    public function querySearch($isPaginated = true)
    {
        $query = RequestForm::query();
        $query->search($this->selectedStatus,
        $this->selectedStatusPurchase,
        $this->selectedId,
        $this->selectedFolio,
        $this->selectedName,
        $this->selectedStartDate,
        $this->selectedEndDate,
        $this->selectedRequester,
        $this->selectedAdmin,
        $this->selectedPurchaser,
        $this->selectedProgram
        )
        ->with('user', 'userOrganizationalUnit', 'purchaseMechanism', 'eventRequestForms.signerOrganizationalUnit', 'father:id,folio,has_increased_expense', 'purchasers', 'purchasingProcess')
        ->latest();

        return ($isPaginated) ? $query->paginate(50) : $query->get();
    }

    public function render()
    {
        // dd($this->querySearch());
        return view('livewire.request-form.search-requests', [
            'request_forms' => $this->querySearch(),
            'users' => User::where('organizational_unit_id', 37)->orderBy('name','asc')->get(),
        ]);
    }

    public function export()
    {
        return Excel::download(new RequestFormsExport($this->querySearch(false)), 'requestFormsExport_'.Carbon::now().'.xlsx');
    }
}

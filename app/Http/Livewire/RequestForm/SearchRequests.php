<?php

namespace App\Http\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;

use Livewire\WithPagination;

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

    public function render()
    {
        return view('livewire.request-form.search-requests', [
            'request_forms' => RequestForm::search($this->selectedStatus,
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
                ->latest()
                ->paginate(50),
        ]);
    }
}

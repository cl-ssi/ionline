<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

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

    public function render()
    {
        return view('livewire.replacement-staff.search-requests',[
            'fundaments' => RstFundamentManage::all(),
            'requests' => RequestReplacementStaff::latest()
                ->where('user_id', Auth::user()->id)
                ->search($this->selectedStatus,
                    $this->selectedId,
                    $this->selectedStartDate,
                    $this->selectedEndDate,
                    $this->selectedName,
                    $this->selectedFundament,
                    $this->selectedFundamentDetail,
                    $this->selectedNameToReplace
                )
                ->paginate(50)
        ]);
    }

    public function updatedselectedFundament($fundament_id)
    {
        $this->fundamentsDetail = RstDetailFundament::where('fundament_manage_id', $fundament_id)->get();
    }

    
}

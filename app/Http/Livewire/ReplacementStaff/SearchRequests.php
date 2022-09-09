<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\RstDetailFundament;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use Illuminate\Support\Facades\Auth;

class SearchRequests extends Component
{
    public $selectedStatus = null;
    public $selectedId = null;
    public $selectedStartDate = null;
    public $selectedEndDate = null;
    public $selectedName = null;
    public $selectedFundament = null;
    public $selectedFundamentDetail = null;

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
                    $this->selectedFundamentDetail
                )
                ->take(50)
                ->get()
        ]);
    }

    public function updatedselectedFundament($fundament_id)
    {
        $this->fundamentsDetail = RstDetailFundament::where('fundament_manage_id', $fundament_id)->get();
        // dd($this->fundamentDetails);
        // if($fundament_id == 4){
        //     $this->otherFundamentInput = '';
        // }
    }

    
}

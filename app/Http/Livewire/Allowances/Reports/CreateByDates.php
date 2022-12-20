<?php

namespace App\Http\Livewire\Allowances\Reports;

use Livewire\Component;

use App\Models\Allowances\Allowance;
use Carbon\Carbon;

class CreateByDates extends Component
{
    public $selectedStartDate = null;
    public $selectedEndDate = null;
    public $disabled = null;

    public function mount(){
        $this->selectedStartDate = Carbon::now()->format('Y-m-d');
        $this->selectedEndDate = Carbon::now()->format('Y-m-d');;
    }
    
    public function render()
    {
        $allowances = Allowance::latest()
            ->whereBetween('from', [$this->selectedStartDate, $this->selectedEndDate." 23:59:59"])
            ->paginate(50);
        
        if($allowances){
            $this->disabled = 'disabled';
        }

        return view('livewire.allowances.reports.create-by-dates', compact('allowances'));
    }
}

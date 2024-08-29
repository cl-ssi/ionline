<?php

namespace App\Livewire\Allowances\Reports;

use Livewire\Component;

use App\Models\Allowances\Allowance;
use Carbon\Carbon;
use Livewire\WithPagination;

class CreateByDates extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

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

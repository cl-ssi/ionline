<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;

class ListOfShifts extends Component
{
	public $staffInShift;
	public $actuallyYear;
	public $actuallyMonth;
	public $days;
	public $modalProperty ="hidden";

	public function editStatusDay($sfId){
		$this->modalProperty = "";
	}

    public function render()
    {
        return view('livewire.rrhh.list-of-shifts');
    }
}

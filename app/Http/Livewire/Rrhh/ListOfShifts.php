<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use \Illuminate\Session\SessionManager;
class ListOfShifts extends Component
{
	// public $staffInShift;
	// public $actuallyYear;
	// public $actuallyMonth;
 //    // public $actuallyOrgUnit;
	// public $days;
    public $statusx;
        public function render()
    {
        return view('livewire.rrhh.list-of-shifts');
        // return view('livewire.rrhh.list-of-shifts',[compact($this->staffInShift,$this->days),'actuallyMonth'=>$this->actuallyMonth,'actuallyYear'=>$this->actuallyYear]);
    }

 
    public function editStatusDay($staffInShift,$actuallyYear,$actuallyMonth,$days)

    {   
        // $this->days=2;
         $this->staffInShift = $staffInShift;
        $this->actuallyYear = $actuallyYear;
        $this->actuallyMonth = $actuallyMonth;
        // $this->actuallyOrgUnit = $actuallyOrgUnit;
        $this->days = $days;
        $this->statusx++;
    }


 
}

<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use \Illuminate\Session\SessionManager;
use Session;

class ListOfShifts extends Component
{
	public $staffInShift;
	public $actuallyYear;
	public $actuallyMonth;
    // public $actuallyOrgUnit;
	public $days;
    public $statusx;
        private $colors = array(
            1 => "lightblue",
            2 => "#2471a3",
            3 => " #52be80 ",
            4 => "orange",
            5 => "#ec7063",
            6 => "#af7ac5",
            7 => "#f4d03f",
            8 => "gray",
    );
     public function editShiftDayX($id)

    {   
        $this->statusx++;
        // $this->render();
           // dd($id);
    }


        public function render()
    {
        return view('livewire.rrhh.list-of-shifts',["statusColors"=>$this->colors]);
        // return view('livewire.rrhh.list-of-shifts',[compact($this- >staffInShift,$this->days),'actuallyMonth'=>$this->actuallyMonth,'actuallyYear'=>$this->actuallyYear]);
    }

    public function mount($staffInShift,$actuallyYear,$actuallyMonth,$days)
    {
        $this->staffInShift = $staffInShift;
        $this->actuallyYear = $actuallyYear;
        $this->actuallyMonth = $actuallyMonth;
        // $this->actuallyOrgUnit = $actuallyOrgUnit;
        $this->days = $days;
        $this->statusx=0;

    }
   
    public function editShiftDay($id){

        // $this->emit('clearModal', $this->shiftDay->id);
        $this->filered ="on"; 
        // $this->emit('setshiftUserDay', $this->shiftDay->id);
        $this->emit('setshiftUserDay', $id);


        // $this->shiftDay = ShiftUserDay::find($id);
        // $this->count++;
        // dd($this->shiftDay);
    }

 
}

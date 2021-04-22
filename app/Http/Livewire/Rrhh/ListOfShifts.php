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

     public function editShiftDay($id)

    {   
        $this->statusx++;
        // $this->render();
           // dd($id);
    }


        public function render()
    {
        return view('livewire.rrhh.list-of-shifts');
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
    // public function mount()
    // {
    //     //  $users = Session::get('users');
    //     // $cargos = Session::get('cargos');
    //     // $sTypes = Session::get('sTypes');
    //     $this->days = Session::get('days');
    //     $this->actuallyMonth = Session::get('actuallyMonth');
    //      // $this->actuallyDay = Session::get('actuallyDay');
    //     $this->actuallyYear = Session::get('actuallyYear');
    //     // $months = $this->months;
    //     //$actuallyOrgUnit = Session::get('actuallyOrgUnit');
    //     //$staff = Session::get('staff');
    //     $this->actuallyShift = Session::get('actuallyShift');
    //     $this->staffInShift = Session::get('staffInShift');
    //     $this->statusx=0;

    // }
   

 
}

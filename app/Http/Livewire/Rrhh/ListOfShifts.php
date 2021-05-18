<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use \Illuminate\Session\SessionManager;
use App\Models\Rrhh\ShiftUser;
use Carbon\Carbon;
use App\Rrhh\OrganizationalUnit;
use Session;

class ListOfShifts extends Component
{
	public $staffInShift;
	public $actuallyYear;
	public $actuallyMonth;
    public $actuallyOrgUnit;
	public $days;
    public $statusx;
    public $actuallyShift;
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
        
    protected $listeners = ['refreshListOfShifts' => '$refreh'];

     public function ref()

    {   

         // $this->reset();
        $this->emit("renderShiftDay");
        // $this->statusx++;  
        // $this->render();
           // dd($id);
        // $this->mount($this->staffInShift,$this->actuallyYear,$this->actuallyMonth,$this->days);
        // $this->render();
        // $this->$refresh;/
    }


        public function render()
    {
        return view('livewire.rrhh.list-of-shifts',["statusColors"=>$this->colors]);
        // return view('livewire.rrhh.list-of-shifts',[compact($this- >staffInShift,$this->days),'actuallyMonth'=>$this->actuallyMonth,'actuallyYear'=>$this->actuallyYear]);
    }

    public function mount()
    {
        // $this->staffInShift = $staffInShift;
        // $this->actuallyYear = $actuallyYear;
        // $this->actuallyMonth = $actuallyMonth;
        // // $this->actuallyOrgUnit = $actuallyOrgUnit;
        // $this->days = $days;
        // $this->statusx=0;
         $cargos = OrganizationalUnit::all();

        if(Session::has('actuallyYear') && Session::get('actuallyYear') != "")
            $this->actuallyYear = Session::get('actuallyYear');
        else
            $actuallyYear = Carbon::now()->format('Y');


        if(Session::has('actuallyMonth') && Session::get('actuallyMonth') != "")
            $this->actuallyMonth = Session::get('actuallyMonth');
        else
            $this->actuallyMonth = Carbon::now()->format('m');


        if(Session::has('days') && Session::get('days') != "")
            $this->days = Session::get('days');
        else
           $this->days = Carbon::now()->daysInMonth;

        if(Session::has('actuallyOrgUnit') && Session::get('actuallyOrgUnit') != "")
            $this->actuallyOrgUnit = Session::get('actuallyOrgUnit');
        else    
            $this->actuallyOrgUnit = $cargos->first();


        if(Session::has('actuallyDay') && Session::get('actuallyDay') != "")
            $this->actuallyDay = Session::get('actuallyDay');
        else
            $this->actuallyDay = Carbon::now()->format('d');


        if(Session::has('actuallyShift') && Session::get('actuallyShift') != "")
            $this->actuallyShift = Session::get('actuallyShift');
        else
            $this->actuallyShift=$sTypes->first();

        $this->staffInShift = ShiftUser::where('organizational_units_id', $this->actuallyOrgUnit->id )->where('shift_types_id',$this->actuallyShift->id)->where('date_up','>=',$this->actuallyYear."-".$this->actuallyMonth."-".$this->days)->where('date_from','<=',$this->actuallyYear."-".$this->actuallyMonth."-".$this->days)->get();

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

<?php

namespace App\Livewire\Rrhh;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
use App\Models\Rrhh\ShiftUser;
use Session;

class DeleteShift extends Component
{
    public $startdate;
    public $enddate;
    public $ShiftUserDay;
    public $ShiftUser;
    public $actuallyGroup = "Sin grupo";
    public $cantDaysToDelete = 0 ;
    public   $actuallyShift;
    public $userName;
    public $deleteAll = 0 ;
    public $rutUser;
    public $daysList= array();
    public function render()
    {   
        return view('livewire.rrhh.delete-shift');
    }
    public function mount(){
       
       $this->cantDaysToDelete = 0;
       // $this->deleteAll = 1;
    }

    #[On('setDataToDeleteModal')]
    public function setValues($actuallyShiftDay){
        // $this->clearDeleteModal();
        // dd($actuallyShiftDay[0]["id"]);
        $this->ShiftUser = ShiftUser::find($actuallyShiftDay[0]["id"]);
        // dd($this->ShiftUser->user->fullName);
       $this->userName = $this->ShiftUser->user->fullName;
       $this->rutUser =  $this->ShiftUser->user->runFormat();
        $this->actuallyGroup =  htmlentities(Session::get('groupname'));
       $this->actuallyShift = Session::get('actuallyShift');
       $this->actuallyShiftUserDay = Session::get('actuallyShift');

        $this->startdate =  Session::get('actuallyYear')."-". Session::get('actuallyMonth') ."-01" ;

        $this->enddate =  Session::get('actuallyYear') 
        ."-". Session::get('actuallyMonth') ."-31";
        $days =  (object) $this->ShiftUser->days;
        foreach ($days->where("day",">=",$this->startdate)->where("day","<=",$this->enddate) as $day) {
// dd(   $days );
        // foreach ($days as $day) {
        //     if($day->day >= $this->startdate && $day->day <= $this->enddate)
                array_push($this->daysList,$day);
        }
        $this->cantDaysToDelete = sizeof( $this->daysList );

    }
    public function changeDate(){
        $this->daysList= array();
        if($this->deleteAll == 0){

            $days =  (object) $this->ShiftUser->days;
            foreach ($days->where("day",">=",$this->startdate)->where("day","<=",$this->enddate) as $day) {
                array_push($this->daysList,$day);
            }
        }else{
            $days =  (object) $this->ShiftUser->days;
            foreach ($days as $day) {
                array_push($this->daysList,$day);
            }
        }
        $this->cantDaysToDelete = sizeof( $this->daysList );
    }

    public function clearDeleteModal(){
         $this->reset();
    }

    public function confirmDeleteDays(){
        for($i=0;$i<sizeof($this->daysList);$i++){
            $ShiftUserDay = ShiftUserDay::find($this->daysList[$i]["id"]); 
            // dd($ShiftUserDay);
            $ShiftUserDay->delete();
        }
        session()->flash('warning', 'Se han eliminado los dias seleccionados ');
        return redirect()->route('rrhh.shiftManag.index');
    }
}

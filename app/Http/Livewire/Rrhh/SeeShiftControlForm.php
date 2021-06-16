<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
use App\Models\Rrhh\ShiftUser;
use App\Models\Rrhh\ShiftUserDay;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;   
class SeeShiftControlForm extends Component
{
    public  $usr;
	public  $usr2;
	public  $actuallyMonth;
	public  $actuallyYears;
	public  $days;
	public $log;
    public $shifsUsr;
    public $timePerDay = array(

        'L' => array("from"=>"08:00","to"=>"20:00","time"=>12),
        'N' => array("from"=>"20:00","to"=>"08:00","time"=>12),
        'D' => array("from"=>"08:00","to"=>"17:00","time"=>8),
        'F' => array("from"=>"","to"=>"","time"=>0),

     );
    public $shiftStatus = array(
        1=>"asignado",
        2=>"completado",
        3=>"turno extra",
        4=>"cambio turno con",
        5=>"licencia medica",
        6=>"fuero gremial",
        7=>"feriado legal",
        8=>"permiso excepcional",
        9 => "Permiso sin goce de sueldo"
        
    );
    public $months = array(

        '01'=>'Enero',
        '02'=>'Febrero',
        '03'=>'Marzo',
        '04'=>'Abril',
        '05'=>'Mayo',
        '06'=>'Junio',
        '07'=>'Julio',
        '08'=>'Agosto',
        '09'=>'Septiembre',
        '10'=>'Octubre',
        '11'=>'Noviembre',
        '12'=>'Diciembre',
    );
	public function mount(){
		$this->days=0;
		$this->log.="mounted";
		$dateFiltered = Carbon::createFromFormat('Y-m-d',  $this->actuallyYears."-".$this->actuallyMonth."-01", 'Europe/London');
		$this->usr2 = User::find($this->usr->id);
        $this->days = $dateFiltered->daysInMonth;

        $this->shifsUsr = ShiftUser::where('date_up','>=',$this->actuallyYears."-".$this->actuallyMonth."-".$this->days)->where('date_from','<=',$this->actuallyYears."-".$this->actuallyMonth."-".$this->days)->where("user_id",$this->usr->id)->first();

	}

	public function setValues($id){

        $dateFiltered = Carbon::createFromFormat('Y-m-d',  $this->actuallyYears."-".$this->actuallyMonth."-01", 'Europe/London');

        $this->days = $dateFiltered->daysInMonth;
        $this->log .="setValues";
        // $this->reset;
    //    $this->emit("setValueToShiftForm",["actuallyYears"=>$this->actuallyYears,"actuallyMonth"=>$this->actuallyMonth,"usr"=>$this->usr->id,"days"=> $this->days]);

		// $this->emit('jsLiveWireTest');

	}
	public function cancel(){
		$this->days = 0;

	}
	public function downloadShiftControlForm(){
		$this->log ="brn";
         return redirect('/rrhh/shift-management/shift-control-form/download');
	}

    public function render()
    {

        return view('livewire.rrhh.see-shift-control-form');
    }
}

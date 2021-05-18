<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Carbon\Carbon;
use App\User;

class SeeShiftControlForm extends Component
{
	public  $usr;
	public  $actuallyMonth;
	public  $actuallyYears;
	public  $days;
	public $log;

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
		// $this->log.="mounted";
		$dateFiltered = Carbon::createFromFormat('Y-m-d',  $this->actuallyYears."-".$this->actuallyMonth."-01", 'Europe/London');
		$this->usr2 = User::find($this->usr->id);
        $this->days = $dateFiltered->daysInMonth;



	}

	public function setValues($id){

        $dateFiltered = Carbon::createFromFormat('Y-m-d',  $this->actuallyYears."-".$this->actuallyMonth."-01", 'Europe/London');

        $this->days = $dateFiltered->daysInMonth;

    //    $this->emit("setValueToShiftForm",["actuallyYears"=>$this->actuallyYears,"actuallyMonth"=>$this->actuallyMonth,"usr"=>$this->usr->id,"days"=> $this->days]);

		// $this->emit('jsLiveWireTest');

	}
	public function cancel(){
		$this->days = 0;

	}
	public function downloadShiftControlForm(){
		$this->log ="brn";
	}

    public function render()
    {

        return view('livewire.rrhh.see-shift-control-form');
    }
}

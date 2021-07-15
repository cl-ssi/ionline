<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Carbon\Carbon;
use App\User;
use App\Models\Rrhh\ShiftUser;
use App\Models\Rrhh\ShiftUserDay;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;  
use App\Models\Rrhh\ShiftClose;
use App\Models\Rrhh\ShiftDateOfClosing;

class SeeShiftControlForm extends Component
{
    public  $usr;
	public  $usr2;
	public  $actuallyMonth;
	public  $actuallyYears;
	public  $days;
	public $log;
    public $shifsUsr;
    public $close=0;
    public $daysForClose;
    // public $cierreDelMes=array();
    public $timePerDay = array(

        'L' => array("from"=>"08:00","to"=>"20:00","time"=>12),
        'N' => array("from"=>"20:00","to"=>"08:00","time"=>12),
        'D' => array("from"=>"08:00","to"=>"17:00","time"=>8),
        'F' => array("from"=>"","to"=>"","time"=>0),

     );
  public $shiftStatus = array(
        1=>"Asignado",
           2=>"Completado",
           3=>"Turno extra",
           4=>"Intercambio de turno con",
           5=>"Licencia medica",
           6=>"Fuero gremial",
           7=>"Feriado legal",
           8=>"Permiso excepcional",
           9 => "Permiso sin goce de sueldo",
           10 => "Descanzo Compensatorio",
           11 => "Permiso Administrativo Completo",
           12 => "Permiso Administrativo Medio Turno Diurno",
           13 => "Permiso Administrativo Medio Turno Nocturno",
           14 => "Permiso a Curso",
           15 => "Ausencia sin justificar",
           16 => "Cambiado por necesidad de servicio",
        
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
        $id = $this->usr->id ;

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
        $cierreDelMes = array();
         if($this->close == 1){
            
            $cierreDelMes = ShiftDateOfClosing::where('close_date','<=',Carbon::now()->format('Y-m-d'))->latest()->first();
            if(isset($cierreDelMes) &&  $cierreDelMes!=""){
                // echo "Cierre del mes econtrad";

            }else{
                $cierreDelMes = (object) array("user_id"=>1,"commentary"=>"","init_date"=>$this->actuallyYears."-".$this->actuallyMonth."-01","close_date"=>$this->actuallyYears."-".$this->actuallyMonth."-".$this->days);
            }
            
            $id = $this->usr->id ;

            $this->daysForClose = ShiftUserDay::where('day','>=',$this->actuallyYears."-".$this->actuallyMonth."-01")->where('day','<=',$this->actuallyYears."-".$this->actuallyMonth."-".$this->days)->whereHas("ShiftUser",  function($q) use($id){
                
                    $q->where('user_id',$id); // Para filtrar solo los dias de la unidad organizacional del usuario
            })->get();
        }
        return view('livewire.rrhh.see-shift-control-form',['cierreDelMes' => $cierreDelMes]);
    }
}

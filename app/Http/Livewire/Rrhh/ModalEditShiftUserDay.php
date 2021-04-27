<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
use App\User;
use App\Models\Rrhh\ShiftUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;	
class ModalEditShiftUserDay extends Component
{	
	public $visibility = "xx";
	public $action = 0;
	public $users;
	public $userIdtoChange =0;
	public $shiftUserDay;	
	public $usersSelect ="none";
	public $changeDayType ="none";
	public $previousStatus;
	public $newStatus;
	public $newWorkingDay;
	public $previousWorkingDay;
    private $tiposJornada = array(
            'F' => "Libre",
            'D' => "Dia",
            'L' => "Largo",
            'N' => "Noche"
    );
 	private $estados = array(
            1 => "Asignado",
            2 => "Completado",
            3 => "Turno Extra",
            4 => "Turno Cambiado",
            5 => "Licencia Medica",
            6 => "Fuero Gremial",
            7 => "Feriado Legal",
            8 => "Permiso Excepcional",
    );
    private $colors = array(
            1 => "lightblue",
            2 => "blue",
            3 => "green",
            4 => "orange",
            5 => "red",
            6 => "purple",
            7 => "yellow",
            8 => "gray",
    );
    protected $listeners = ['setshiftUserDay','clearModal','ChangeWorkingDay'=>'enableChangeTypeOfWorkingDay'];
    public function mount(){
		
		$this->usersSelect ="none";
		$this->changeDayType = "none";
		// $this->newWorkingDay = "F";
    }
    public function clearModal(){
    	// unset($this->shiftUserDay);
    	 $this->reset();
		// $this->emit('setshiftUserDay', $this->shiftDay->id);
    }
	public function setshiftUserDay($sUDId){
		$this->shiftUserDay = ShiftUserDay::find($sUDId);
		$this->previousStatus = $this->shiftUserDay->status;
		$this->newStatus = $this->previousStatus ;
		$this->previousWorkingDay = $this->shiftUserDay->working_day;
		$this->newWorkingDay = $this->previousWorkingDay;

		// $this->users = $this->shiftUserDay->where
		$this->users  = User::where('organizational_unit_id', $this->shiftUserDay->ShiftUser->organizational_unit_id)->get();
		foreach ($this->users as $index => $u) {
			$shiftUser = ShiftUser::where("user_id",$u->id)->get();
			// if( ShiftUser::where("user_id",$u->id)->get() ){
				if( isset($shiftUser) && count($shiftUser) > 0){

					foreach ($shiftUser as  $suser) {
					
						if ( isset($suser->ShiftUserDay) && $suser->ShiftUserDay->where("day","2021-04-27") != null  ){
							$this->users->forget($index);
						}

					}
				}
		}
// 		$users = User::whereHas('posts', function($q){
//     		$q->where('created_at', '>=', '2015-01-01 00:00:00');
// })->get();

	}
	public function cancel(){
		$this->emit('clearModal');

	}
	public function changeAction(){
		/* they can be 1:assigned;2:completed,3:extra shift,4:shift change 5: medical license,6: union jurisdiction,7: legal holiday,8: exceptional permit or did not belong to the service.*/
		if( $this->action ==1 ){ // Cambiar turno con
			$this->newStatus = 4;
			$this->usersSelect="visible";
			$this->changeDayType ="none";
		}elseif($this->action ==2 ){ //cumplido
			$this->newStatus = 2;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
		}elseif($this->action ==3 ){ // licencia
			$this->newStatus = 5;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
		}elseif($this->action ==4 ){ // Fuero gremial
			$this->newStatus = 6;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
		}elseif($this->action ==5 ){ // Feriado Legal
			$this->newStatus = 7;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
		}elseif($this->action ==6 ){ // PErmiso excepcional
			$this->newStatus = 8;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
		}elseif($this->action ==7 ){ // Cambiar tipo de jornada
			// $this->newStatus = 8;
			$this->usersSelect ="none";

			$this->emit('ChangeWorkingDay');
		}else{
			$this->changeDayType ="none";

			$this->usersSelect ="none";
		}
	}
	public function enableAnnouncementDayAvailableFields(){
		// habilitar aqui campos para crear el anuncio de dia de turno disponble
	}
	public function enableChangeTypeOfWorkingDay(){
			$this->changeDayType ="visible";

	}
	public function update(){
		if( ($this->action != 1 && $this->action != 7) &&  isset($this->shiftUserDay) ){


			$this->shiftUserDay->status =$this->newStatus;
			$this->shiftUserDay->update();


			$nHistory = new ShiftDayHistoryOfChanges;
			$nHistory->commentary = "El usuario \"".Auth::user()->name." ". Auth::user()->fathers_family." ". Auth::user()->mothers_family."\" ha modificado el <b>estado</b> de \"".$this->previousStatus." - ".$this->estados[$this->previousStatus]."\" a \"".$this->newStatus." - ".$this->estados[$this->newStatusid]."\"";
			$nHistory->shift_user_day_id = $this->shiftUserDay->id;
			$nHistory->modified_by = Auth::user()->id;
			$nHistory->change_type = 1;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
			$nHistory->day =  $this->shiftUserDay->day;
			$nHistory->previous_value = $this->previousStatus;
			$nHistory->current_value = $this->newStatus;
			$nHistory->save();
		}elseif($this->action == 7 &&  isset($this->shiftUserDay) ){ // Cambiar jornada laborarl
			$this->shiftUserDay->working_day =$this->newWorkingDay;
			$this->shiftUserDay->update();


			$nHistory = new ShiftDayHistoryOfChanges;
			$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family."\" ha modificado el <b>tipo de jornada</b> de \"".$this->previousWorkingDay ." - ".$this->tiposJornada[$this->previousWorkingDay]."\" a \"".$this->newWorkingDay." - ".$this->tiposJornada[$this->newWorkingDay]."\"";
			$nHistory->shift_user_day_id = $this->shiftUserDay->id;
			$nHistory->modified_by = Auth()->user()->id;
			$nHistory->change_type = 2;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
			$nHistory->day =  $this->shiftUserDay->day;
			$nHistory->previous_value = $this->previousStatus;
			$nHistory->current_value = $this->newStatus;
			$nHistory->save();
		}elseif($this->action == 1 &&  isset($this->shiftUserDay) ){ // Asignar dia laboral a otro usuario
			$this->shiftUserDay->status =$this->newStatus;
			$this->shiftUserDay->update();
			if($this->userIdtoChange != 0){ // si el id es ditinto a 0 = dejar dia laboral disponible
				// $chgUsr = User::find( $userIdtoChange );
				// $bTurno = ShiftUser::where()->first();
				$from = date('2018-01-01');
				$to = date('2018-05-02');
				// $bTurno = ShiftUser::whereBetween('reservation_from', [$from, $to])->get();
				$bTurno = ShiftUser::where("user_id",$this->userIdtoChange)->where("date_from","<=",$this->shiftUserDay->day)->where("date_up",">=",$this->shiftUserDay->day)->first(); 
				if(!isset($bTurno)||count($bTurno) < 1){
					 // si no tiene ningun turno asociado a ese rango, se le crea
					$bTurno = new ShiftUser;
					$bTurno->date_from = $from;
					$bTurno->date_up = $to;
					$bTurno->asigned_by = Auth::user()->id;
					$bTurno->user_id = $this->userIdtoChange;
					$bTurno->shift_types_id = $this->shiftUserDay->ShiftUser->shift_types_id;
					$bTurno->organizational_units_id = $this->shiftUserDay->ShiftUser->organizational_units_id;
					$bTurno->save();
				}
				$nDay = new ShiftUserDay;
				$nDay->day = $this->shiftUserDay->day;
				$nDay->commentary = "Dia extra agregado, perteneciente al usuario ".$this->shiftUserDay->ShiftUser->user_id;
				$nDay->status = 3;
				$nDay->shift_user_id = $bTurno->id;
				$nDay->working_day = $this->shiftUserDay->working_day;
				$nDay->save();
				
				
				//si tiene turno creado para ese mes y ese tipo de turno

			}
		}
	}	

    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada,"estados"=>$this->estados,"statusColors"=>$this->colors]);
    }

}

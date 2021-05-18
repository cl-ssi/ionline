<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
use App\User;
use App\Models\Rrhh\ShiftUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;	
use Carbon\Carbon;

class ModalEditShiftUserDay extends Component
{	

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
	public $varLog;
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
    // public function mount(array $headers){
    public function mount(){
		
		// $this->headers = old('http_client_headers', $headers);

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

    	// $this->reset();//
		// echo "setshiftUserDay";
		$this->shiftUserDay = ShiftUserDay::find($sUDId);
		$this->previousStatus = $this->shiftUserDay->status;
		$this->newStatus = $this->previousStatus ;
		$this->previousWorkingDay = $this->shiftUserDay->working_day;
		$this->newWorkingDay = $this->previousWorkingDay;

		// $this->users = $this->shiftUserDay->where
		$this->users  = User::where('organizational_unit_id', $this->shiftUserDay->ShiftUser->organizational_units_id)->get();
		$this->varLog = "";		
		// $this->varLog ="Users Prev: ".json_encode($this->users)."<br>";
		foreach ($this->users as $index => $u) {
			// $this->varLog .= ">> foreach( Index:".$index."; U:".json_encode($u).")  <br>"; 
			$shiftUser = ShiftUser::where("user_id",$u->id)->get();
			// if( ShiftUser::where("user_id",$u->id)->get() ){
			$this->varLog .=">> shiftUser day: " .$this->shiftUserDay->day."<br>";
				if( isset($shiftUser) && count($shiftUser) > 0){

					foreach ($shiftUser as  $suser) {
						// $this->varLog .=" >> foreach  shiftUser <br> ".">> uShiftDays:".json_encode($suser)."<br>";
						if ( isset($suser->days) && $suser->days->where("day",$this->shiftUserDay->day) != null){
							$sUDay = $suser->days->where("day",$this->shiftUserDay->day)->first();
							$this->varLog .=" >> foreach:"."<p align='center'>"." suser : ".$sUDay['working_day']."</p><br>" ;

							if($sUDay['working_day'] !="F" && $sUDay['working_day'] != "" ){
								$this->varLog .="<p align='center'>"." IF UNSET  : ".$index."".$u->id."</p><br>" ;

								$this->users->forget($index);
							}

						}else{
							$this->varLog .=" >> foreach --> else"."<br>";

						}

					}
				}
		}
		// 		$users = User::whereHas('posts', function($q){
		//     		$q->where('created_at', '>=', '2015-01-01 00:00:00');
		// })->get();//seteo el dia para obtener la info
		// $this->render();
	}

	public function cancel(){
    
    	$this->reset();
		// 
		// $this->emit('clearModal');
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
			$nHistory->commentary = "El usuario \"".Auth::user()->name." ". Auth::user()->fathers_family." ". Auth::user()->mothers_family."\" ha modificado el <b>estado</b> de \"".$this->previousStatus." - ".$this->estados[$this->previousStatus]."\" a \"".$this->newStatus." - ".$this->estados[$this->newStatus]."\"";
			$nHistory->shift_user_day_id = $this->shiftUserDay->id;
			$nHistory->modified_by = Auth::user()->id;
			$nHistory->change_type = 1;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
			$nHistory->day =  $this->shiftUserDay->day;
			$nHistory->previous_value = $this->previousStatus;
			$nHistory->current_value = $this->newStatus;
			$nHistory->save();
		}elseif($this->action == 7 &&  isset($this->shiftUserDay) ){ // Cambiar jornada laboral
			$this->shiftUserDay->working_day =$this->newWorkingDay;
			$this->shiftUserDay->update();

			$nHistory = new ShiftDayHistoryOfChanges;
			$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family."\" ha modificado el <b>tipo de jornada</b> de \"".$this->shiftUserDay->shift_user_day_id." - ".$this->tiposJornada[$this->previousWorkingDay]."\" a \"".$this->newWorkingDay." - ".$this->tiposJornada[$this->newWorkingDay]."\"";
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
				$daysOfMonth = Carbon::createFromFormat('Y-m-d',  $this->shiftUserDay->day, 'Europe/London');

				$splitDay = explode("-", $this->shiftUserDay->day);
				$from = date($splitDay[0].'-'.$splitDay[1].'-01');
				$to = date($splitDay[0].'-'.$splitDay[1].'-'.$daysOfMonth->daysInMonth);
				
        		$days = $daysOfMonth->daysInMonth;

				// $bTurno = ShiftUser::whereBetween('reservation_from', [$from, $to])->get();
				// $bTurno = ShiftUser::where("user_id",$this->userIdtoChange)->where("date_from","<=",$this->shiftUserDay->day)->where("date_up",">=",$this->shiftUserDay->day)->first(); 05/04/21 30/04/21  2021/04/01 
				$bTurno = ShiftUser::where("user_id",$this->userIdtoChange)->where("date_from",">=",$from)->where("date_up","<=",$to)->first(); 
				if( !isset($bTurno) || $bTurno == ""){ // si no tiene ningun turno asociado a ese rango, se le crea
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
				$nDay->derived_from = $this->shiftUserDay->id;
				$nDay->save();	
				//si tiene turno creado para ese mes y ese tipo de turno
				$nHistory = new ShiftDayHistoryOfChanges;
				$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha cambiado la asignacion del dia</b> del usuario \"". $this->shiftUserDay->ShiftUser->user_id . "\" al usuario \"" .$this->userIdtoChange."\"";
				$nHistory->shift_user_day_id = $this->shiftUserDay->id;
				$nHistory->modified_by = Auth()->user()->id;
				$nHistory->change_type = 2;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
				$nHistory->day =  $this->shiftUserDay->day;
				$nHistory->previous_value = $this->previousStatus;
				$nHistory->current_value = $this->newStatus;
				$nHistory->save();
			}
		}
		$this->emitUp('refreshListOfShifts');
		// $this->emitSelf('renderShiftDay');
		$this->emitSelf('changeColor',["color"=>$this->colors[$this->shiftUserDay->status]]);
		 $this->reset();
		    // return redirect('/rrhh/shiftManagement');
	}	
    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada,"estados"=>$this->estados,"statusColors"=>$this->colors]);
    }

}

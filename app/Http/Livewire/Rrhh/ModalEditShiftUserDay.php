<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
use App\User;
use App\Models\Rrhh\ShiftUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\ShiftDayHistoryOfChanges;	
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ModalEditShiftUserDay extends Component
{	

	public $action = 0;
	public $users;
	public $userIdtoChange =0;
	public $userIdtoChange2 =0;
	public $shiftUserDay;	
	public $shiftUser;	
	public $usersSelect ="none";
	public $usersSelect2 ="none";
	public $changeDayType ="none";
	public $repeatAction ="none";
	public $addHours ="none";
	public $previousStatus;
	public $newStatus;
	public $newWorkingDay;
	public $previousWorkingDay;
	public $varLog;
	public $repeatToDate;
	public $cantNewHours="00:00";
    private $tiposJornada = array(
            'F' => "Libre",
            'D' => "Dia",
            'L' => "Largo",
            'N' => "Noche",
            "MD" => "Media jornada dia",
            "MN" => "Media jornada nocuturna",
            "MD2" => "Media jornada dia 2",
            "MN2" => "Media jornada nocuturna 2",
    );
 	private $estados = array(
           1=>"Asignado",
           2=>"Completado",
           3=>"Turno extra",
           4=>"Cambio turno con",
           5=>"Ñicencia medica",
           6=>"Fuero gremial",
           7=>"Feriado legal",
           8=>"Permiso excepcional",
           9 => "Permiso sin goce de sueldo",
           10 => "Descanzo Compensatorio",
           11 => "Permiso Administrativo Completo",
           12 => "Permiso Administrativo Medio Turno Diurno",
           13 => "Permiso Administrativo Medio Turno Nocturno",
           14 => "Permiso a Curso",
    );
    private $colors = array(
            1 => "lightblue",
            2 => "#2471a3",
            3 => " #52be80 ",
            4 => "orange",
            5 => "#ec7063",
            6 => "#af7ac5",
            7 => "#f4d03f",
            8 => "gray",
            9  => "yellow",
            10  => "brown",
            11  => "brown",
            12  => "brown",
            13  => "brown",
            14  => "brown",
    );
    protected $listeners = ['setshiftUserDay','clearModal','ChangeWorkingDay'=>'enableChangeTypeOfWorkingDay'];
    // public function mount(array $headers){
    public function mount(){
		
		// $this->headers = old('http_client_headers', $headers);
		$this->varLog = "mont";		

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
		$this->repeatToDate = $this->shiftUserDay->day;
		// $this->users = $this->shiftUserDay->where
		$this->users  = User::where('organizational_unit_id', $this->shiftUserDay->ShiftUser->organizational_units_id)->get();
		$this->varLog = "X";		
		$this->shiftUser = $this->shiftUserDay->ShiftUser->days;
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
				} // Con este foreac recorro todos los que tiene ese dia libre por si se desa intercambiar
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
		/* they can be 1:assigned;2:completed,3:extra shift,4:shift change 5: medical license,6: union jurisdiction,7: legal holiday,8: exceptional permit or did not belong 9to the service, 9. ALLOWANCE WITHOUT PAYMENT*/
		if( $this->action ==1 ){ // Cambiar turno con
			$this->newStatus = 4;
			$this->usersSelect="visible";
			$this->changeDayType ="none";
			$this->repeatAction="none";
			$this->usersSelect2 ="none";
			$this->addHours = "none" ;

		}elseif($this->action ==2 ){ //cumplido
			$this->newStatus = 2;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
			$this->repeatAction="visible";
			$this->usersSelect2 ="none";
			$this->addHours = "none" ;


		}elseif($this->action ==3 ){ // licencia
			$this->newStatus = 5;
			$this->usersSelect ="none";
			$this->changeDayType ="none";
			$this->repeatAction="visible";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==4 ){ // Fuero gremial
			$this->newStatus = 6;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==5 ){ // Feriado Legal
			$this->newStatus = 7;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;
			
		}elseif($this->action ==6 ){ // PErmiso excepcional
			$this->newStatus = 8;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;
		
		}elseif($this->action ==7 ){ // Cambiar tipo de jornada
			// $this->newStatus = 8;
			$this->usersSelect ="none";
			$this->repeatAction="none";
			$this->usersSelect2 ="none";
			$this->addHours = "none" ;

			$this->emit('ChangeWorkingDay');
		}elseif($this->action ==8 ){ // PErmiso excepcional sin sueldo
			$this->newStatus = 9;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;
		
		}elseif($this->action ==9 ){ // Descanzo Compensatorio
			$this->newStatus = 10;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==10 ){ // Permiso Administrativo Completo
			$this->newStatus = 11;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==11 ){ // Permiso Administrativo Medio Turno Diurno
			$this->newStatus = 12;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==12 ){ // Permiso Administrativo Medio Turno Nocturno
			$this->newStatus = 13;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==13 ){ // Permiso a curso
			$this->newStatus = 14;
			$this->usersSelect ="none";
			$this->repeatAction="visible";
			$this->changeDayType ="none";
			$this->usersSelect2 ="visible";
			$this->addHours = "none" ;

		}elseif($this->action ==14 ){ // Aresr ooras
			// $this->newStatus = 8;
			$this->usersSelect ="none";
			$this->repeatAction="none";
			$this->usersSelect2 ="none";
			$this->addHours = "visible" ;
			/*
			  9 => "Permiso sin goce de sueldo",
           10 => "Descanzo Compensatorio",
           11 => "Permiso Administrativo Completo",
           12 => "Permiso Administrativo Medio Turno Diurno",
           13 => "Permiso Administrativo Medio Turno Nocturno",
           14 => "Permiso a Curso", */
		
		}else{
			$this->changeDayType ="none";
			$this->repeatAction="none";

			$this->usersSelect ="none";
		}
	}
	public function enableAnnouncementDayAvailableFields(){
		// habilitar aqui campos para crear el anuncio de dia de turno disponble
	}
	public function enableChangeTypeOfWorkingDay(){

			$this->changeDayType ="visible";
	}
	public function update(){//funcion que actualiza la informacion segun el estado elegido en el modal
		if( ($this->action != 1 && $this->action != 7 && $this->action != 14) &&  isset($this->shiftUserDay) ){

				if($this->repeatToDate == $this->shiftUserDay->day ){ // Si esque no se repiten

					$this->shiftUserDay->status =$this->newStatus;
					$this->shiftUserDay->update();

					if($this->userIdtoChange2 != 0){ // si esque quiere replazarlo con otro usuario

						$daysOfMonth = Carbon::createFromFormat('Y-m-d',  $this->shiftUserDay->day, 'Europe/London');

						$splitDay = explode("-", $this->shiftUserDay->day);
						$from = date($splitDay[0].'-'.$splitDay[1].'-01');
						$to = date($splitDay[0].'-'.$splitDay[1].'-'.$daysOfMonth->daysInMonth);
				
        				$days = $daysOfMonth->daysInMonth;

				
						$bTurno = ShiftUser::where("user_id",$this->userIdtoChange2)->where("date_from",">=",$from)->where("date_up","<=",$to)->first(); 
						if( !isset($bTurno) || $bTurno == ""){ // si no tiene ningun turno asociado a ese rango, se le crea
							$bTurno = new ShiftUser;
							$bTurno->date_from = $from;
							$bTurno->date_up = $to;	
							$bTurno->asigned_by = Auth::user()->id;
							$bTurno->user_id = $this->userIdtoChange2;
							$bTurno->shift_types_id = $this->shiftUserDay->ShiftUser->shift_types_id;
							$bTurno->organizational_units_id = $this->shiftUserDay->ShiftUser->organizational_units_id;
							$bTurno->groupname ="";
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
						$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha cambiado la asignacion del dia</b> del usuario \"". $this->shiftUserDay->ShiftUser->user_id . "\" al usuario \"" .$this->userIdtoChange2."\"";
						$nHistory->shift_user_day_id = $this->shiftUserDay->id;
						$nHistory->modified_by = Auth()->user()->id;
						$nHistory->change_type = 2;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
						$nHistory->day =  $this->shiftUserDay->day;
						$nHistory->previous_value = $this->previousStatus;
						$nHistory->current_value = $this->newStatus;
						$nHistory->save();
					}
					$nHistory = new ShiftDayHistoryOfChanges;
					$nHistory->commentary = "El usuario \"".Auth::user()->name." ". Auth::user()->fathers_family." ". Auth::user()->mothers_family."\" ha modificado el <b>estado</b> de \"".$this->previousStatus." - ".$this->estados[$this->previousStatus]."\" a \"".$this->newStatus." - ".$this->estados[$this->newStatus]."\"";
					$nHistory->shift_user_day_id = $this->shiftUserDay->id;
					$nHistory->modified_by = Auth::user()->id;
					$nHistory->change_type = 1;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario, 4 cambio confirmado por usuario, 5 cambio confirmado por administrador
					$nHistory->day =  $this->shiftUserDay->day;
					$nHistory->previous_value = $this->previousStatus;
					$nHistory->current_value = $this->newStatus;
					$nHistory->save();
				}else{

					$actuallyShift = $this->shiftUserDay->ShiftUser;
					$days = $actuallyShift->days;
					$days = $this->shiftUser;
					$ranges = CarbonPeriod::create($this->shiftUserDay->day, $this->repeatToDate );
						foreach ($ranges as $date) {

							
							$day = $this->shiftUser->where('day',$date->format('Y-m-d'))->first();
							// $day = $day[0] ;
							$day->status = $this->newStatus; 
							$day->update();


							$nHistory = new ShiftDayHistoryOfChanges;
							$nHistory->commentary = "El usuario \"".Auth::user()->name." ". Auth::user()->fathers_family." ". Auth::user()->mothers_family."\" ha modificado el <b>estado</b> de \"".$this->previousStatus." - ".$this->estados[$this->previousStatus]."\" a \"".$this->newStatus." - ".$this->estados[$this->newStatus]."\"";
							$nHistory->shift_user_day_id = $day->id;
							$nHistory->modified_by = Auth::user()->id;
							$nHistory->change_type = 1;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario, 4 cambio confirmado por usuario, 5 cambio confirmado por administrador
							$nHistory->day =  $day->day;
							$nHistory->previous_value = $this->previousStatus;
							$nHistory->current_value = $this->newStatus;
							$nHistory->save();

							if($this->userIdtoChange2 != 0){ // si esque quiere replazarlo con otro usuario

								$daysOfMonth = Carbon::createFromFormat('Y-m-d',  $day->day, 'Europe/London');
								$splitDay = explode("-", $day->day);
								$from = date($splitDay[0].'-'.$splitDay[1].'-01');
								$to = date($splitDay[0].'-'.$splitDay[1].'-'.$daysOfMonth->daysInMonth);
        						$days = $daysOfMonth->daysInMonth;
								$bTurno = ShiftUser::where("user_id",$this->userIdtoChange2)->where("date_from",">=",$from)->where("date_up","<=",$to)->first(); 
								if( !isset($bTurno) || $bTurno == ""){ // si no tiene ningun turno asociado a ese rango, se le crea
									$bTurno = new ShiftUser;
									$bTurno->date_from = $from;
									$bTurno->date_up = $to;	
									$bTurno->asigned_by = Auth::user()->id;
									$bTurno->user_id = $this->userIdtoChange2;
									$bTurno->shift_types_id = $day->ShiftUser->shift_types_id;
									$bTurno->organizational_units_id = $day->ShiftUser->organizational_units_id;
									$bTurno->groupname ="";
									$bTurno->save();
								}
								$nDay = new ShiftUserDay;
								$nDay->day = $day->day;
								$nDay->commentary = "Dia extra agregado, perteneciente al usuario ".$day->ShiftUser->user_id;
								$nDay->status = 3;
								$nDay->shift_user_id = $bTurno->id;
								$nDay->working_day = $day->working_day;
								$nDay->derived_from = $day->id;
								$nDay->save();	
								//si tiene turno creado para ese mes y ese tipo de turno
								$nHistory = new ShiftDayHistoryOfChanges;
								$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha cambiado la asignacion del dia</b> del usuario \"". $day->ShiftUser->user_id . "\" al usuario \"" .$this->userIdtoChange2."\"";
								$nHistory->shift_user_day_id = $day->id;
								$nHistory->modified_by = Auth()->user()->id;
								$nHistory->change_type = 2;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
								$nHistory->day =  $day->day;
								$nHistory->previous_value = $this->previousStatus;
								$nHistory->current_value = $this->newStatus;
								$nHistory->save();
							}else{ // si el id es = 0 osea DEJAR DIA DISPONIBLE

								$nHistory = new ShiftDayHistoryOfChanges;
								$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha dejado el día disponible \"";
								$nHistory->shift_user_day_id = $this->shiftUserDay->id;
								$nHistory->modified_by = Auth()->user()->id;
								$nHistory->change_type = 7;//0:asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario;4:Confirmado por el usuario 5: confirmado por el administrador, 6:rechazado por usuario?, 7 Dejar disponible
								$nHistory->day =  $this->shiftUserDay->day;
								$nHistory->previous_value = $this->previousStatus;
								$nHistory->current_value = $this->newStatus;
								$nHistory->save();
							}
								
						}
				}


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

				// busco si tiene turno entre las fechas de donde corresponde el dia
				$bTurno = ShiftUser::where("user_id",$this->userIdtoChange)->where("date_from",">=",$from)->where("date_up","<=",$to)->first(); 
				if( !isset($bTurno) || $bTurno == ""){ // si no tiene ningun turno asociado a ese rango, se le crea
					$bTurno = new ShiftUser;
					$bTurno->date_from = $from;
					$bTurno->date_up = $to;	
					$bTurno->asigned_by = Auth::user()->id;
					$bTurno->user_id = $this->userIdtoChange;
					$bTurno->shift_types_id = $this->shiftUserDay->ShiftUser->shift_types_id;
					$bTurno->organizational_units_id = $this->shiftUserDay->ShiftUser->organizational_units_id;
					$bTurno->groupname ="";
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
				$nHistory->change_type = 3;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
				$nHistory->day =  $this->shiftUserDay->day;
				$nHistory->previous_value = $this->previousStatus;
				$nHistory->current_value = $this->newStatus;
				$nHistory->save();
			}else{ // si el id es = 0 osea DEJAR DIA DISPONIBLE

				$nHistory = new ShiftDayHistoryOfChanges;
				$nHistory->commentary = "El usuario \"".Auth()->user()->name." ". Auth()->user()->fathers_family ." ". Auth()->user()->mothers_family ."\" <b>ha dejado el día disponible \"";
				$nHistory->shift_user_day_id = $this->shiftUserDay->id;
				$nHistory->modified_by = Auth()->user()->id;
				$nHistory->change_type = 7;//0:asignado 1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario;4:Confirmado por el usuario 5: confirmado por el administrador, 6:rechazado por usuario?, 7 Dejar disponible
				$nHistory->day =  $this->shiftUserDay->day;
				$nHistory->previous_value = $this->previousStatus;
				$nHistory->current_value = $this->newStatus;
				$nHistory->save();
			}
		}elseif($this->action == 14 &&  isset($this->shiftUserDay)){
			$nShiftUserDay = new ShiftUserDay;
			$nShiftUserDay->day = $this->shiftUserDay->day;
			$nShiftUserDay->status = 1;
			$nShiftUserDay->shift_user_id = $this->shiftUserDay->shift_user_id;
			$nShiftUserDay->working_day = "+".$this->cantNewHours;
			$nShiftUserDay->commentary = "Horas agregadas por necesidad de servicio";
			$nShiftUserDay->save();
		}
		$this->emitUp('refreshListOfShifts');
		// $this->emitSelf('renderShiftDay');
		$this->emitSelf('changeColor',["color"=>$this->colors[$this->shiftUserDay->status]]);
		 $this->reset();
		    return redirect('/rrhh/shift-management');
	}	

	public function confirmExtraDay(){
		 return redirect()->route('rrhh.shiftManag.confirmDay',[$this->shiftUserDay]);	 
	}
    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada,"estados"=>$this->estados,"statusColors"=>$this->colors]);
    }

}

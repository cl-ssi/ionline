<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
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
	}
	public function cancel(){
		$this->emit('clearModal');

	}
	public function changeAction(){
		/* they can be 1:assigned;2:completed,3:extra shift,4:shift change 5: medical license,6: union jurisdiction,7: legal holiday,8: exceptional permit or did not belong to the service.*/
		if( $this->action ==1 ){
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
		if( ($this->action != 1 || $this->action != 7) &&  isset($this->shiftUserDay) ){


			$this->shiftUserDay->status =$this->newStatus;
			$this->shiftUserDay->update();


			$nHistory = new ShiftDayHistoryOfChanges;
			$nHistory->commentary = Auth()->user()->name." ". Auth()->user()->fathers_family." ". Auth()->user()->mothers_family." ha modificado el estado de ".$this->previousStatus." a ".$this->newStatus;
			$nHistory->shift_user_day_id = $this->shiftUserDay->id;
			$nHistory->modified_by = Auth()->user()->id;
			$nHistory->change_type = 1;//1:cambio estado, 2 cambio de tipo de jornada, 3 intercambio con otro usuario
			$nHistory->day =  $this->shiftUserDay->day;
			$nHistory->previous_value = $this->previousStatus;
			$nHistory->current_value = $this->newStatus;
			$nHistory->save();
		}
	}
    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada,"estados"=>$this->estados,"statusColors"=>$this->colors]);
    }

}

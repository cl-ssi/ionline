<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
	
class ModalEditShiftUserDay extends Component
{	
	public $visibility = "xx";
	public $action = 0;
	public $users;
	public $userId =0;
	public $shiftUserDay;	
	public $usersSelect ="invisible";
	public $previousStatus;
	public $newStatus;
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
    protected $listeners = ['setshiftUserDay','clearModal'];
    public function mount(){
		
		$this->usersSelect ="invisible";

    }
    public function clearModal(){
    	// unset($this->shiftUserDay);
    	 $this->reset();
		// $this->emit('setshiftUserDay', $this->shiftDay->id);

    }
	public function setshiftUserDay($sUDId){
		$this->shiftUserDay = ShiftUserDay::find($sUDId);
		$this->previousStatus = $this->shiftUserDay->status;
	}
	public function cancel(){
		$this->emit('clearModal');

	}
	public function changeAction(){
		/* they can be 1:assigned;2:completed,3:extra shift,4:shift change 5: medical license,6: union jurisdiction,7: legal holiday,8: exceptional permit or did not belong to the service.*/
		if( $this->action ==1 ){
			$this->usersSelect="visible";

		}elseif($this->action ==2 ){ //cumplido
			$this->newStatus = 2;
			$this->usersSelect ="invisible";

		}elseif($this->action ==3 ){ // licencia
			$this->newStatus = 5;
			$this->usersSelect ="invisible";

		}elseif($this->action ==4 ){ // Fuero gremial
			$this->newStatus = 6;
			$this->usersSelect ="invisible";

		}elseif($this->action ==5 ){ // Feriado Legal
			$this->newStatus = 7;
			$this->usersSelect ="invisible";

		}elseif($this->action ==6 ){ // PErmiso excepcional
			$this->newStatus = 8;
			$this->usersSelect ="invisible";

		}else{
			$this->usersSelect ="invisible";
		}
	}
    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada,"estados"=>$this->estados]);
    }

}

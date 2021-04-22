<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUserDay;
	
class ModalEditShiftUserDay extends Component
{	
	public $visibility = "xx";
	public $action = 0;
	public $users;
	public $shiftUserDay;	
	public $usersSelect ="hidden";
    private $tiposJornada = array(
            'F' => "Libre",
            'D' => "Dia",
            'L' => "Largo",
            'N' => "Noche"
    );
    protected $listeners = ['setshiftUserDay','clearModal'];

    public function clearModal(){
    	// unset($this->shiftUserDay);
    	 $this->reset();
		// $this->emit('setshiftUserDay', $this->shiftDay->id);

    }
	public function setshiftUserDay($sUDId){
		$this->shiftUserDay = ShiftUserDay::find($sUDId);
	}
	public function cancel(){
		$this->emit('clearModal');

	}
    public function render()
    {
        return view('livewire.rrhh.modal-edit-shift-user-day',["tiposJornada"=>$this->tiposJornada]);
    }

}

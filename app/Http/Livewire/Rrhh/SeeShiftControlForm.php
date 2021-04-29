<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\User;

class SeeShiftControlForm extends Component
{
	public  $usr;
	public  $usr2;
	public function downloadShiftControlForm($idUser){
		echo json_encode("module" );
	}
	public function setJsFunc(){

		$this->emit('jsLiveWireTest');

	}
    public function render()
    {

        return view('livewire.rrhh.see-shift-control-form');
    }
}

<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use App\Models\Rrhh\ShiftUser;
use App\Models\Rrhh\ShiftUserDay;

class AddDayOfShiftModal extends Component
{   
    public $shiftDay;
    public $journalType = "L";
    public $day;

    protected $listeners = ['setAddModalValue' => "setValue"];

    public function render()
    {
        return view('livewire.rrhh.add-day-of-shift-modal');
    }
    public function clearAddModal(){
         $this->reset();
    }

    public function confirmAddDay(){

        // dd($this->journalType);
        $nShiftUserDay = new ShiftUserDay;
        
        $nShiftUserDay->day = $this->day;
        $nShiftUserDay->commentary = "Agregado por necesidad en servicio";
        $nShiftUserDay->status = 3;
        $nShiftUserDay->shift_user_id = $this->shiftDay->id;
        $nShiftUserDay->working_day = $this->journalType;
        $nShiftUserDay->save();

        session()->flash('success', 'Se agregó el dia '.$this->day.' a <b>'.$this->shiftDay->user->name.' '.$this->shiftDay->user->fathers_family.'</b>');
        return redirect()->route('rrhh.shiftManag.index'); 
    }
    public function setValue($s,$d){
        // dd($d);
        $this->shiftDay = ShiftUser::find($s["id"]);
        $this->day = $d[0];

        // dd($this->day);
    }
}

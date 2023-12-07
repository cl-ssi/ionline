<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;

use App\Models\Rrhh\Shift;
use App\User;

class ShiftsIndex extends Component
{
    public $shifts;

    public $user;
    public $year;
    public $month;
    public $quantity;
    public $observation;

    protected $listeners = ['emit_user_id'];
 
    public function emit_user_id(User $user)
    {
        $this->user = $user;
    }

    protected $rules = [
        'user' => 'required',
        'year' => 'required',
        'month' => 'required',
        'quantity' => 'required',
    ];

    public function delete(Shift $shift)
    {
        $shift->delete();
        session()->flash('message', 'Se ha eliminado el turno.');
    }

    public function save()
    {
        $this->validate();

        // if($this->user->contracts){
        //     foreach($this->user->contracts as $contract){
        //         $contract->shift = true;
        //         $contract->save();
        //     }
        // }

        $shift = new Shift();
        $shift->user_id = $this->user->id;
        $shift->year = $this->year;
        $shift->month = $this->month;
        $shift->quantity = $this->quantity;
        $shift->observation = $this->observation;
        $shift->save();

        session()->flash('message', 'Se ha registrado el turno.');
    }

    public function render()
    {
        $this->shifts = Shift::all();
        return view('livewire.rrhh.shifts-index');
    }
}

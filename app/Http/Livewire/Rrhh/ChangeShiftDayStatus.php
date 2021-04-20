<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;

class ChangeShiftDayStatus extends Component
{	

	public $count = 5;

    public function increment()
    {
        $this->count++;
    }
    public function render()
    {
        return view('livewire.rrhh.change-shift-day-status');
    }
}

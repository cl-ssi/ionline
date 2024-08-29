<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;

class AddDayOfShiftButton extends Component
{
    public $shiftUser;
    public $day;
    public function render()
    {
        return view('livewire.rrhh.add-day-of-shift-button');
    }
    public function setAddModalValue(){
        $this->dispatch('setAddModalValue', s:$this->shiftUser, d:$this->day);
    }

}

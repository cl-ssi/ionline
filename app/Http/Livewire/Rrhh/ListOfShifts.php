<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;

class ListOfShifts extends Component
{
	public $staffInShift;
	public $actuallyYear;
	public $actuallyMonth;
	public $days;
    public function render()
    {
        return view('livewire.rrhh.list-of-shifts');
    }
}

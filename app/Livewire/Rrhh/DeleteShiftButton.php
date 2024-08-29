<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;

class DeleteShiftButton extends Component
{
    public $actuallyShiftUserDay;
    public function render()
    {
        return view('livewire.rrhh.delete-shift-button');
    }
    public function deleteActually(){
        $this->dispatch("setDataToDeleteModal",actuallyShiftDay: $this->actuallyShiftUserDay);

    }
}

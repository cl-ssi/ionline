<?php

namespace App\Http\Livewire\ServiceRequest;

use Livewire\Component;

class CreateTypes extends Component
{
    public $program_contract_type;
    public $type;

    public function render()
    {
        $this->emit('listener',$this->program_contract_type, $this->type);
        return view('livewire.service-request.create-types');
    }
}

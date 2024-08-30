<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;
use Livewire\Attributes\On; 

class NameToReplace extends Component
{
    public $nameToReplace;
    public $requestReplacementStaff;
    public $disabled = null;

    public function mount() {
        if($this->requestReplacementStaff) {
            $this->nameToReplace = $this->requestReplacementStaff->name_to_replace;

            if($this->requestReplacementStaff->fundament_manage_id == 4){
                $this->disabledNameToReplace();
            }
            else{
                $this->enableNameToReplace();
            }
        }
    }

    public function render()
    {
        return view('livewire.replacement-staff.name-to-replace');
    }

    #[On('disabledNameToReplace')] 
    public function disabledNameToReplace(){
        $this->disabled = 'disabled';
    }

    #[On('enableNameToReplace')] 
    public function enableNameToReplace(){
        $this->disabled = '';
    }
}

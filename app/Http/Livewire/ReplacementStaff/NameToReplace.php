<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class NameToReplace extends Component
{
    public $nameToReplace;

    public $requestReplacementStaff;

    protected $listeners = ['disabledNameToReplace', 'enableNameToReplace'];

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

    public function disabledNameToReplace(){
        $this->disabled = 'disabled';
    }

    public function enableNameToReplace(){
        $this->disabled = '';
    }
}

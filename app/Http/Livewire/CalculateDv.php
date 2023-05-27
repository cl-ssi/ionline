<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CalculateDv extends Component
{
    public $run;
    public $dv;

    public $requestReplacementStaff;

    /* Para editar y precargar los select */
    public $runSelected = null;
    public $dvSelected = null;

    protected $listeners = ['disabledRunDv', 'enableRunDv'];

    public $disabled = null;

    public function mount() {
        if($this->requestReplacementStaff) {
            $this->run = $this->requestReplacementStaff->run;

            if($this->requestReplacementStaff->fundament_manage_id == 4){
                $this->disabledRunDv();
            }
            else{
                $this->enableRunDv();
            }
        }
    }

    public function render()
    {
        $run = intval($this->run);
        $s=1;
        for($m=0;$run!=0;$run/=10)
            $s=($s+$run%10*(9-$m++%6))%11;
        $this->dv = chr($s?$s+47:75);

        return view('livewire.calculate-dv');
    }

    public function disabledRunDv(){
        $this->disabled = 'disabled';
    }

    public function enableRunDv(){
        $this->disabled = '';
    }
}

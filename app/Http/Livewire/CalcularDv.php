<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CalcularDv extends Component
{
    public $run;
    public $dv;

    public function mount() {
        if(old('run')) {
            $this->run = old('run');
        }
    }

    public function render()
    {
        $run = intval($this->run);
        $s=1;
        for($m=0;$run!=0;$run/=10)
            $s=($s+$run%10*(9-$m++%6))%11;
        $this->dv = chr($s?$s+47:75); 

        return view('livewire.calcular-dv');
    }
}

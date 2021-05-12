<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class Training extends Component
{
    public $inputs = [];
    public $i = 1;
    public $replacementStaff;
    public $count = 0;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
        $this->count++;
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        $this->count--;
    }

    public function mount($replacementStaff)
    {
        $this->replacementStaff = $replacementStaff;
    }

    public function render()
    {
        return view('livewire.replacement-staff.training');
    }
}

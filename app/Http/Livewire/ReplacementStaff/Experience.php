<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class Experience extends Component
{
    public $inputs = [];
    public $i = 1;
    public $replacementStaff;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function mount($replacementStaff)
    {
        $this->replacementStaff = $replacementStaff;
    }

    public function render()
    {
        return view('livewire.replacement-staff.experience', $this->replacementStaff);
    }
}

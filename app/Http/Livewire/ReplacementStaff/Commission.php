<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class Commission extends Component
{
    public $inputs = [];
    public $i = 1;
    public $users;
    public $technicalEvaluation;
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

    public function mount($users, $technicalEvaluation)
    {
        $this->users = $users;
        $this->technicalEvaluation = $technicalEvaluation;
    }

    public function render()
    {
        return view('livewire.replacement-staff.commission', compact($this->users, $this->technicalEvaluation));
    }
}

<?php

namespace App\Http\Livewire\ReplacementStaff;

use Livewire\Component;

class Commission extends Component
{
    public $inputs = [];
    public $i = 1;
    public $users;
    public $technicalEvaluation;

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

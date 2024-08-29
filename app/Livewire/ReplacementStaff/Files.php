<?php

namespace App\Livewire\ReplacementStaff;

use Livewire\Component;

class Files extends Component
{
    public $inputs = [];
    public $i = 1;
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

    public function mount($technicalEvaluation)
    {
        $this->technicalEvaluation = $technicalEvaluation;
    }

    public function render()
    {
        return view('livewire.replacement-staff.files',
            [
                'technicalEvaluation' => $this->technicalEvaluation
            ]);
    }
}

<?php

namespace App\Livewire\Authorities;

use Livewire\Component;
use App\Models\Profile\Subrogation;

class ShowSubrogees extends Component
{
    public $absent;
    public $user_id;
    public $subrogations;
    public $organizational_unit;
    public $organizational_unit_id;
    public $organizational_unit_name;


    public function mount($organizational_unit_name)
    {
        $this->user_id = auth()->id();
        $this->absent = auth()->user()->absent;
        $this->organizational_unit_name = $organizational_unit_name;
        $this->subrogations = Subrogation::where('organizational_unit_id', $this->organizational_unit_id)
            ->where('type','manager')
            ->orderBy('level')
            ->get();
    }

    public function render()
    {
        return view('livewire.authorities.show-subrogees');
    }
}
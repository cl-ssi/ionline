<?php

namespace App\Http\Livewire\Authorities;

use Livewire\Component;
use App\Models\Profile\Subrogation;

class ShowSubrogees extends Component
{
    public $absent;
    public $user_id;
    public $subrogations;
    public $organizational_unit_id;


    public function mount()
    {
        $this->user_id = auth()->id();
        $this->absent = auth()->user()->absent;
        $this->subrogations = Subrogation::where('organizational_unit_id', $this->organizational_unit_id)
            ->orderBy('level')
            ->get();
    }

    public function render()
    {
        return view('livewire.authorities.show-subrogees');
    }
}
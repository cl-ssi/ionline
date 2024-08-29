<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use Livewire\Component;

class MaintainerPlaces extends Component
{
    public $establishment;

    public function mount(Establishment $establishment)
    {
        //
    }

    public function render()
    {
        return view('livewire.inventory.maintainer-places');
    }
}

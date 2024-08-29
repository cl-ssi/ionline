<?php

namespace App\Livewire\Parameters;

use App\Models\Establishment;
use Livewire\Component;

class MaintainerPlaces extends Component
{
    public $establishment;

    public function mount(Establishment $establishment)
    {

    }
    
    public function render()
    {
        return view('livewire.parameters.maintainer-places')->extends('layouts.bt4.app');
    }
}

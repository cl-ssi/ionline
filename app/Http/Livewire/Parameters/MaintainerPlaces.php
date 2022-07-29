<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;

class MaintainerPlaces extends Component
{
    public function render()
    {
        return view('livewire.parameters.maintainer-places')->extends('layouts.app');
    }
}

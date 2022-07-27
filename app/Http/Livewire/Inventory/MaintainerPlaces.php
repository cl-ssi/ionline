<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;

class MaintainerPlaces extends Component
{
    public function render()
    {
        return view('livewire.inventory.maintainer-places')->extends('layouts.app');
    }
}

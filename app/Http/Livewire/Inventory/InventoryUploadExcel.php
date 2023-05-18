<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use Livewire\Component;

class InventoryUploadExcel extends Component
{

    public $establishment;

    public function mount(Establishment $establishment)
    {
        //
    }


    public function render()
    {
        return view('livewire.inventory.inventory-upload-excel')->extends('layouts.app');
    }
}

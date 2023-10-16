<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\Inventory;
use Livewire\Component;

class CreateTransfer extends Component
{
    public $inventory;

    public function mount(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    public function render()
    {
        return view('livewire.inventory.create-transfer')
            ->extends('layouts.bt4.app');
    }

    public function myUserUsingId($value)
    {
        $this->user_using_id = $value;
    }

    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }

    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }
}

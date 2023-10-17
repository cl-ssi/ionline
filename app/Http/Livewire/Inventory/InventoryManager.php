<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use Livewire\Component;

class InventoryManager extends Component
{
    public function render()
    {
        return view('livewire.inventory.inventory-manager', [
            'establishments' => $this->getEstablishments(),
        ])->extends('layouts.bt4.app');
    }

    public function getEstablishments()
    {
        return Establishment::orderByDesc('created_at')->paginate(10);
    }
}

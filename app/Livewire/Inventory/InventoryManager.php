<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use Livewire\Component;

class InventoryManager extends Component
{
    public function render()
    {
        return view('livewire.inventory.inventory-manager', [
            'establishments' => $this->getEstablishments(),
        ]);
    }

    public function getEstablishments()
    {
        return Establishment::orderByDesc('created_at')->paginate(10);
    }
}

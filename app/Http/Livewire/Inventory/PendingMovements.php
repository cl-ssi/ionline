<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Inv\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PendingMovements extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory.pending-movements', [
            'movements' => $this->getMovements(),
        ])->extends('layouts.app');
    }

    public function getMovements()
    {
        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereUserResponsibleId(Auth::id())
            ->orderBy('id')
            ->paginate(10);

        return $movements;
    }
}

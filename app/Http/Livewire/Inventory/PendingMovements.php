<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PendingMovements extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;

    public function mount(Establishment $establishment)
    {
        //
    }

    public function render()
    {
        return view('livewire.inventory.pending-movements', [
            'movements' => $this->getMovements(),
        ])->extends('layouts.bt4.app');
    }

    public function getMovements()
    {
        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereUserResponsibleId(Auth::id())
            ->orderByDesc('id')
            ->paginate(10);

        return $movements;
    }
}

<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\InventoryMovement;
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
        ]);
    }

    public function getMovements()
    {
        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereUserResponsibleId(auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        return $movements;
    }
}

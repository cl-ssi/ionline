<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\InventoryMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile\Subrogation;

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
        $userId = Auth::id();

        // TODO: Add Auth::user()->IAmSubrogantOf->AmIAuthorityFromOu == true
        $subrogatedIds = Auth::user()->IAmSubrogantOf->pluck('id')->toArray();
        $responsibleIds = array_unique(array_merge([$userId], $subrogatedIds));

        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereIn('user_responsible_id', $responsibleIds)
            ->orderByDesc('id')
            ->paginate(10);

        return $movements;
    }
}

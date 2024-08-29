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
        $isAuthority = Auth::user()->getAmIAuthorityFromOuAttribute()->isNotEmpty();

        $responsibleIds = [$userId];

        if ($isAuthority) {
            $authorities = Auth::user()->getAmIAuthorityFromOuAttribute();
            foreach ($authorities as $authority) {
                $subrogations = Subrogation::where('level', 1)
                    ->where('organizational_unit_id', $authority->organizational_unit_id)
                    ->where('type', 'manager')
                    ->get();

                $subrogatedIds = $subrogations->pluck('user_id')->toArray();
                $responsibleIds = array_merge($responsibleIds, $subrogatedIds);
            }
            $responsibleIds = array_unique($responsibleIds);
        }


        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereIn('user_responsible_id', $responsibleIds)
            ->orderByDesc('id')
            ->paginate(10);

        return $movements;
    }
}

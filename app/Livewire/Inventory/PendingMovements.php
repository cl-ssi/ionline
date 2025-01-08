<?php

namespace App\Livewire\Inventory;

use App\Models\Establishment;
use App\Models\Inv\InventoryMovement;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
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
        $extraIds = [];        
        if(Auth::user()->IAmSubrogantOf->isNotEmpty()){
            $subrogatedIds = Auth::user()->IAmSubrogantOf->map(function ($item) {
                $authorities = $item->AmIAuthorityFromOu;
                return $authorities->isNotEmpty()?$authorities->pluck('user_id')->toArray():null;
            })->all();
            $subrogatedIds = Arr::flatten($subrogatedIds);
            $extraIds = array_unique(array_merge($extraIds, $subrogatedIds));
        }
        if(Auth::user()->AmIAuthorityFromOu->isNotEmpty()){
            $subrogatedIds = Auth::user()->IAmSubrogantOf->pluck('id')->toArray();
            $extraIds = array_unique(array_merge($extraIds, $subrogatedIds));
        }
        $responsibleIds = array_unique(array_merge([Auth::id()], $extraIds));
        $movements = InventoryMovement::query()
            ->whereReceptionConfirmation(false)
            ->whereIn('user_responsible_id', $responsibleIds)
            ->orderByDesc('id')
            ->paginate(10);

        return $movements;
    }
}

<?php

namespace App\Livewire\Inventory;

use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Profile\Subrogation;

class AssignedProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $product_type;

    public function mount()
    {
        $this->product_type = '';
    }

    public function render()
    {
        return view('livewire.inventory.assigned-products', [
            'inventories' => $this->getInventories()
        ]);
    }

    public function getInventories()
    {
        $search = "%$this->search%";
        $userId = Auth::id();

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

        $inventories = Inventory::query()
            ->when($this->product_type == 'using', function($query) use ($userId) {
                $query->whereRelation('inventoryUsers', 'user_id', '=', $userId);
            })
            ->when($this->product_type == 'responsible', function ($query) use ($responsibleIds) {
                $query->whereIn('user_responsible_id', $responsibleIds);
            })
            ->when($this->product_type == '', function($query) use ($userId, $responsibleIds) {
                $query->whereIn('user_responsible_id', $responsibleIds)
                        ->orwhereRelation('inventoryUsers', 'user_id', '=', $userId);
            })
            ->whereHas('lastMovement', function($query) {
                $query->whereNotNull('reception_date');
            })
            ->where(function ($query) use ($search) {
                $query->where('number', 'like', $search)
                    ->orWhere('old_number', 'like', $search) 
                    ->orWhereHas('unspscProduct', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                     })
                    ->orWhereHas('product', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    })
                    ->orWhere('description', 'like', $search)
                    ->orWhereHas('place', function ($query) use ($search) {
                        $query->where('name', 'like', $search)
                            ->orWhere('architectural_design_code', 'like', $search)
                            ->orWhereHas('location', function ($query) use ($search) {
                                $query->where('name', 'like', $search);
                            });
                      });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return $inventories;
    }

    public function removeInventoryUser($inventoryUserId)
    {
        InventoryUser::where('id', $inventoryUserId)->delete();
        session()->flash('message', 'Usuario eliminado exitosamente.');
        $this->getInventories();
    }

}

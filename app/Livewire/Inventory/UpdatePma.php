<?php

namespace App\Livewire\Inventory;

use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Livewire\Component;

class UpdatePma extends Component
{
    use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $place_id = null;
    public $new_place_id = null;
    public $place = null;
    public $placeNew = null;
    public $selectAll = false;
    public $updateCompleted = false;
    public $selectedItems = [];
    public $selectAllText = 'Seleccionar todos';
    public $search = '';

    #[On('myPlaceId')] 
    public function myPlaceId($value, $key)
    {
        if ($key === 'old') {
            $this->place_id = $value;
        } elseif ($key === 'new') {
            $this->new_place_id = $value;
        }
    }    
    public function render()
    {
        return view('livewire.inventory.update-pma', [
            'inventories' => $this->getInventories(),
            'place' => $this->place,
            'placeNew' => $this->placeNew,
            'establishment' => auth()->user()->establishment,
        ]);
    }
    
    public function getInventories()
    {
        $search = "%$this->search%";
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
        
        $inventoriesQuery = Inventory::whereIn('user_responsible_id', $responsibleIds)
            ->when($this->place_id, function($q){
                $q->where('place_id', $this->place_id);
            })
            ->when(strlen($this->search) > 2, function($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('number', 'like', $search)->orWhere('old_number', 'like', $search) 
                        ->orWhereHas('unspscProduct', function ($query) use ($search) {
                            $query->where('name', 'like', $search);
                        })
                        ->orWhereHas('product', function ($query) use ($search) {
                            $query->where('name', 'like', $search)
                                    ->orWhere('name', 'like', $search);
                        })
                        ->orWhere('description', 'like', $search)
                        ->orWhereHas('place', function ($query) use ($search) {
                            
                            $query->where('name', 'like', $search)
                            ->orWhere('architectural_design_code', 'like', $search)
                                    ->orWhereHas('location', function ($query) use ($search) {
                                        $query->where('name', 'like', $search);
                                    });
                        });
                });
            });
        return $inventoriesQuery->orderByDesc('id')->paginate(50);
    }

    public function updateSelected()
    {
        
        if (!$this->new_place_id) {
            $this->addError('new_place_id', 'Debe seleccionar una nueva ubicación.');
            return;
        }
    
        
        $newPlace = Place::find($this->new_place_id);        
        foreach ($this->selectedItems as $inventoryId => $isSelected) {
            if ($isSelected) {
                $inventory = Inventory::find($inventoryId);
                if ($inventory) {
                    $lastMovement = $inventory->lastMovement;
                    $inventory->update(['place_id' => $newPlace->id]);
                    if ($lastMovement) {
                        $lastMovement->update(['place_id' => $newPlace->id]);
                    }
                }
            }
        }
    
        
        $this->resetData();
        $this->updateCompleted = true;
    }

    public function resetData()
    {
        $this->place_id = null;
        $this->new_place_id = null;
        $this->place = null;
        $this->placeNew = null;
        $this->selectAll = false;
        $this->selectedItems = [];
    }

    public function toggleSelectAll()
    {
        if ($this->selectAllText == 'Seleccionar todos') {
            $this->selectAll();
            $this->selectAllText = 'Deseleccionar todos';
        } else {
            $this->deselectAll();
            $this->selectAllText = 'Seleccionar todos';
        }
    }

    public function selectAll()
    {
        $this->selectedItems = array_fill_keys($this->inventories->pluck('id')->toArray(), true);
    }    

    public function deselectAll()
    {
        $this->selectedItems = [];
    }
}
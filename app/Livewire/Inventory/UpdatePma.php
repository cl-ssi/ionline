<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class UpdatePma extends Component
{
    use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public $place_id = null;
    public $new_place_id = null;
    public $inventories = [];
    public $place = null;
    public $placeNew = null;
    public $selectAll = false;
    public $updateCompleted = false;
    public $selectedItems = [];
    public $selectAllText = 'Seleccionar todos';
    public $searchTerm = '';

    public function mount()
    {
        $this->selectedItems = array_fill(0, count($this->inventories), false);
        $this->inventories = Inventory::where('user_responsible_id', auth()->user()->id)->get();
    }

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
        $inventoriesQuery = Inventory::where('place_id', $this->place_id)
            ->where('user_responsible_id', auth()->user()->id);    
        
        if ($this->searchTerm) {
            $inventoriesQuery->where(function ($query) {
                $query->where('number', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('old_number', 'like', '%' . $this->searchTerm . '%');
            });
        }
    
        $inventories = $inventoriesQuery->paginate(50);
    
        return view('livewire.inventory.update-pma', [
            'inventories' => $inventories,
            'place' => $this->place,
            'placeNew' => $this->placeNew,
            'establishment' => auth()->user()->establishment,
        ]);
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
        $this->inventories = [];
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
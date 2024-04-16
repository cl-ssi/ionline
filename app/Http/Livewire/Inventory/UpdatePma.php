<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;

class UpdatePma extends Component
{
    public $place_id = null;
    public $new_place_id = null;    
    public $inventories = [];
    public $place = null;
    public $placeNew = null;
    public $selectAll = false;
    public $selectedItems = [];
    public $updateCompleted = false;

    public function mount()
    {
        $this->selectedItems = array_fill(0, count($this->inventories), false);
    }

    protected $listeners = [
        'myPlaceId',        
    ];

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
            'inventories' => $this->inventories,
            'place' => $this->place,
            'placeNew' => $this->placeNew,
            'establishment' => auth()->user()->establishment,
        ]);
    }

    public function search()
    {
        $this->inventories = Inventory::whereHas('lastConfirmedMovement', function ($query) {
                $query->where('place_id', $this->place_id);
                $query->where('user_responsible_id', auth()->user()->id);
            })->get();
    
        $this->place = Place::find($this->place_id);
    }

    public function selectAllItems()
    {
        $this->selectAll = !$this->selectAll;        
        $this->selectedItems = array_fill(0, count($this->inventories), $this->selectAll);
    }

    public function updateSelected()
    {
        // Validar que se haya seleccionado una nueva ubicación        
        if (!$this->new_place_id) {
            $this->addError('new_place_id', 'Debe seleccionar una nueva ubicación.');
            return;
        }

        // Obtener la nueva ubicación a la que se van a trasladar los elementos seleccionados
        $newPlace = Place::find($this->new_place_id);

        // Iterar sobre los elementos seleccionados
        foreach ($this->selectedItems as $index => $isSelected) {
            if ($isSelected) {
                $inventory = $this->inventories[$index];

                // Crear un nuevo movimiento de inventario
                InventoryMovement::create([
                    'inventory_id' => $inventory->id,
                    'place_id' => $newPlace->id,
                    'user_responsible_id' => auth()->user()->id,
                    'reception_date' => now(),
                ]);
            }
        }       


        $this->resetData();
        $this->updateCompleted = true;

        // Mostrar el mensaje de actualización completada
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



}

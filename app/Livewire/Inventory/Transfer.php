<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Http\Requests\Inventory\CreateMovementRequest;
use App\Models\User;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Illuminate\Database\Eloquent\Builder;


class Transfer extends Component
{
    use WithPagination;
	protected $paginationTheme = 'bootstrap';
    public $inventory;
    public $user_using_id = null;
    public $user_responsible_id = null;
    public $new_user_responsible_id = null;
    public $old_user_responsible_id = null;
    public $place_id = null;
    public $installation_date;
    public $has_product = null;
    public $has_inventories;
    public $selectedInventories = [];
    public $selectAllText = 'Seleccionar todos';
    public $searchTerm = '';

    #[On('myOldUserResponsibleId')] 
    public function myOldUserResponsibleId($value)
    {        
        $this->old_user_responsible_id = $value;
    }
    
    #[On('myUserResponsibleId')] 
    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }

    #[On('myNewUserResponsibleId')] 
    public function myNewUserResponsibleId($value)
    {
        $this->new_user_responsible_id = $value;
    }

    #[On('myUserUsingId')] 
    public function myUserUsingId($value)
    {
        $this->user_using_id = $value;
    }

    #[On('myPlaceId')] 
    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }

    public function rules()
    {
        return (new CreateMovementRequest())->rules();
    }

    public function render()
    {
        $inventories = $this->search();
        

        return view('livewire.inventory.transfer', compact('inventories'));
    }

    public function search()
    {
        $inventoriesQuery = Inventory::where('user_responsible_id', $this->old_user_responsible_id)->latest();

        if ($this->searchTerm) {
            $inventoriesQuery->where(function (Builder $query) {
                $query->where('number', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('old_number', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('unspscProduct', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    })
                    ->orWhereHas('place.location', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    })
                    ->orWhereHas('place', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    })
                    ->orWhereHas('using', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%')
                              ->orWhere('fathers_family', 'like', '%' . $this->searchTerm . '%');
                    });

            });
        }

        $paginateQuery = clone $inventoriesQuery;
        $this->has_inventories = $paginateQuery->get();
        return $paginateQuery->paginate(50);
    }

    public function transfer()
    {
        foreach($this->selectedInventories as $inventoryId => $isSelected) {
            if ($isSelected) {
                $inventory = Inventory::findOrFail($inventoryId);

                $dataValidated = $this->validate([
                    'user_responsible_id' => 'required',
                    'user_using_id' => 'nullable',
                    'place_id' => 'nullable',
                ]);

                $dataValidated['user_responsible_ou_id'] = optional(User::find($dataValidated['user_responsible_id'])->organizationalUnit)->id;
                $dataValidated['user_sender_id'] = auth()->id();
                $dataValidated['observations'] = 'movimiento por traspaso masivo de inventario';

                //$userUsing = User::find($dataValidated['user_using_id']);
                $place = Place::find($dataValidated['place_id']);

                // if($userUsing)
                // {
                //     $dataValidated['user_using_ou_id'] = $userUsing->organizational_unit_id;
                // }
                // else
                // {
                //     $dataValidated['user_using_id'] = $inventory->lastMovement->user_using_id;
                //     $dataValidated['user_using_ou_id'] = $inventory->lastMovement->user_using_ou_id;
                // }

                if($place)
                {
                    $dataValidated['place_id'] = $place->id;
                }
                else
                {
                    $dataValidated['place_id'] = $inventory->lastMovement->place_id ?? null;
                }

                $dataValidated['inventory_id'] = $inventory->id;

                InventoryMovement::withoutEvents(function () use ($dataValidated) {
                    InventoryMovement::create($dataValidated);
                });
            }
        }

        $this->resetInput();
        session()->flash('success', 'Los Items del Usuario fueron trasladados exitosamente, esperando confirmación de recepción por parte del usuario para finalizar el proceso'); 
        return redirect()->route('inventories.transfer');
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
        
        $this->selectedInventories = array_fill_keys($this->has_inventories->pluck('id')->toArray(), true);
    }

    public function deselectAll()
    {
        $this->selectedInventories = [];
    }


    public function resetInput()
    {
        $this->reset([
            'user_responsible_id',
            'new_user_responsible_id',
        ]);
    }
}

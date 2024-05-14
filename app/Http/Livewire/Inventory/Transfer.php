<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Http\Requests\Inventory\CreateMovementRequest;
use App\Models\User;
use App\Models\Inv\InventoryMovement;
use App\Models\Parameters\Place;
use Livewire\WithPagination;

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
    


    protected $listeners = [
        'myUserResponsibleId',
        'myNewUserResponsibleId',
        'myOldUserResponsibleId',
        'myUserUsingId',
        'myPlaceId',
    ];

    public function myOldUserResponsibleId($value)
    {        
        $this->old_user_responsible_id = $value;
    }
    
    
    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }


    public function myNewUserResponsibleId($value)
    {
        $this->new_user_responsible_id = $value;
    }

    public function myUserUsingId($value)
    {
        $this->user_using_id = $value;
    }

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
        $inventoriesQuery = Inventory::where('user_responsible_id', $this->old_user_responsible_id)->latest();
        $paginateQuery = clone $inventoriesQuery;
        $inventories = $paginateQuery->paginate(50);
        
        $this->has_inventories = $inventoriesQuery->get();
        $this->has_product = !$inventories->isEmpty();
        return view('livewire.inventory.transfer', ['inventories' => $inventories]);
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

                $userUsing = User::find($dataValidated['user_using_id']);
                $place = Place::find($dataValidated['place_id']);

                if($userUsing)
                {
                    $dataValidated['user_using_ou_id'] = $userUsing->organizational_unit_id;
                }
                else
                {
                    $dataValidated['user_using_id'] = $inventory->lastMovement->user_using_id;
                    $dataValidated['user_using_ou_id'] = $inventory->lastMovement->user_using_ou_id;
                }

                if($place)
                {
                    $dataValidated['place_id'] = $place->id;
                }
                else
                {
                    $dataValidated['place_id'] = $inventory->lastMovement->place_id;
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

    public function resetInput()
    {
        $this->reset([
            'user_responsible_id',
            'new_user_responsible_id',
        ]);
    }
}

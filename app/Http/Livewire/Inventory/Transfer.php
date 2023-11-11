<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Http\Requests\Inventory\CreateMovementRequest;
use App\User;
use App\Models\Inv\InventoryMovement;

class Transfer extends Component
{

    public $inventory;
    public $user_using_id = null;
    public $user_responsible_id = null;
    public $new_user_responsible_id = null;
    public $old_user_responsible_id = null;
    public $place_id = null;
    public $installation_date;
    public $has_product = null;
    public $has_inventories;
    


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
        $inventories = $inventoriesQuery->paginate(50);
        $this->has_inventories = $inventoriesQuery->get();

        $this->has_product = !$inventories->isEmpty();

        return view('livewire.inventory.transfer', ['inventories' => $inventories]);
    }

    public function transfer()
    {
        $dataValidated = $this->validate();

        $userResponsible = User::find($dataValidated['user_responsible_id']);
        $userUsing = User::find($dataValidated['user_using_id']);
        $dataValidated['user_responsible_ou_id'] = optional($userResponsible->organizationalUnit)->id;
        $dataValidated['user_sender_id'] = auth()->id();
        if($userUsing)
            $dataValidated['user_using_ou_id'] = optional($userUsing->organizationalUnit)->id;

        foreach($this->has_inventories as $inventory)
        {
            $dataValidated['inventory_id'] = $inventory->id;
            $movement = InventoryMovement::create($dataValidated);
            $inventory->update([
                'user_responsible_id' => $this->user_responsible_id,
                'user_using_id' => $this->user_using_id
                
            ]);
        }
        $this->resetInput();
        session()->flash('success', 'Los Items del Usuario fueron trasladados exitosamente');
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

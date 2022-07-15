<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Requests\Inventory\CreateMovementRequest;
use App\Models\Inv\InventoryMovement;
use App\User;
use Livewire\Component;

class RegisterMovement extends Component
{
    public $inventory;
    public $user_using_id;
    public $user_responsible_id;
    public $place_id;
    public $installation_date;

    protected $listeners = [
        'myUserUsingId',
        'myUserResponsibleId',
        'myPlaceId',
    ];

    public function render()
    {
        return view('livewire.inventory.register-movement');
    }

    public function rules()
    {
        return (new CreateMovementRequest())->rules();
    }

    public function myUserUsingId($value)
    {
        $this->user_using_id = $value;
    }

    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }

    public function myPlaceId($value)
    {
        $this->place_id = $value;
    }

    public function addMovement()
    {
        $dataValidated = $this->validate();
        $userResponsible = User::find($dataValidated['user_responsible_id']);
        $userUsing = User::find($dataValidated['user_using_id']);

        $dataValidated['user_responsible_ou_id'] = optional($userResponsible->organizationalUnit)->id;
        $dataValidated['user_using_ou_id'] = optional($userUsing->organizationalUnit)->id;

        $movements = InventoryMovement::create($dataValidated);
        $this->inventory->movements()->save($movements);

        $this->emit('clearSearchUser');
        $this->emit('clearSearchPlace');
        $this->emit('updateMovementIndex');
        $this->emit('updateMovement');

        $this->resetInput();
    }

    public function resetInput()
    {
        $this->user_using_id = null;
        $this->user_responsible_id = null;
        $this->place_id = null;
        $this->installation_date = null;
    }
}

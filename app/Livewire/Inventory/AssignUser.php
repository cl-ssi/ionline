<?php

namespace App\Livewire\Inventory;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryUser;

class AssignUser extends Component
{
    public $userType;
    public $inventory;
    public $user_id;
    public $establishment;

    public function mount($userType, Inventory $inventory)
    {
        $this->userType = $userType;
        $this->inventory = $inventory;
        $this->establishment = auth()->user()->establishment;
    }

    #[On('setUserId')]
    public function setUserId($value)
    {
        $this->user_id = $value;
    }

    public function assignUser()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
        ]);


        $existingAssignment = InventoryUser::where('inventory_id', $this->inventory->id)
                                            ->where('user_id', $this->user_id)
                                            ->first();

        if ($existingAssignment) {
            session()->flash('message-error', 'El usuario ya está asignado a este inventario.');
            return;
        }

        InventoryUser::create([
            'inventory_id' => $this->inventory->id,
            'user_id' => $this->user_id,
        ]);

        if ($this->userType == 'admin') {
            return redirect()
                ->to(route('inventories.index', $this->establishment))
                ->with('message-success-inventory', 'El usuario ha sido asignado exitosamente.');
        }

        if ($this->userType == 'user') {
            return redirect()
                ->to(route('inventories.assigned-products'))
                ->with('message-success-inventory', 'El usuario ha sido asignado exitosamente.');
        }
    }



    public function render()
    {
        return view('livewire.inventory.assign-user');
    }
}

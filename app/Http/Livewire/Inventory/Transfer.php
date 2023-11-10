<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class Transfer extends Component
{

    public $inventory;
    public $user_using_id;
    public $user_responsible_id = null;
    public $new_user_responsible_id = null;
    public $place_id;
    public $installation_date;
    public $has_product = null;
    public $has_inventories;


    protected $listeners = [
        'myUserResponsibleId',
        'myNewUserResponsibleId',
    ];


    public function myUserResponsibleId($value)
    {
        $this->user_responsible_id = $value;
    }

    public function myNewUserResponsibleId($value)
    {
        $this->new_user_responsible_id = $value;        
    }

    public function render()
    {
        $inventoriesQuery = Inventory::where('user_responsible_id', $this->user_responsible_id)->latest();
        $inventories = $inventoriesQuery->paginate(50);
        $this->has_inventories = $inventoriesQuery->get();

        $this->has_product = !$inventories->isEmpty();

        return view('livewire.inventory.transfer', ['inventories' => $inventories]);
    }

    public function transfer()
    {
        // Verificar si hay inventarios para evitar errores
        if ($this->has_inventories->count() > 0 and $this->new_user_responsible_id and $this->user_responsible_id) {
            foreach ($this->has_inventories as $inventory) {
                if($inventory->user_using_id = $this->user_responsible_id) 
                {
                    $inventory->update([
                        'user_responsible_id' => $this->new_user_responsible_id,
                        'user_using_id' => null,
                    ]);
                }
                else
                {
                    $inventory->update([
                        'user_responsible_id' => $this->new_user_responsible_id,
                    ]);
                }

                InventoryMovement::create([
                    'inventory_id' => $inventory->id,
                    'user_responsible_id' => $this->new_user_responsible_id,
                    'user_sender_id' => $this->new_user_responsible_id,
                ])

            }

            session()->flash('success', 'Los items fueron agregados masivamente y se creó un nuevo movimiento para esta transferencia de productos');
            // $this->resetInput();
        } else {
            session()->flash('error', 'No hay inventarios para transferir.');
        }
    }

    public function resetInput()
    {
        $this->reset([
            'user_responsible_id',
            'new_user_responsible_id',
        ]);
    }
}

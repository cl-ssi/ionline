<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Requests\Inventory\CheckTransferRequest;
use App\Models\Inv\InventoryMovement;
use Livewire\Component;

class CheckTransfer extends Component
{
    public $movement;
    public $status;
    public $observations;

    public function mount(InventoryMovement $movement)
    {
        $this->movement = $movement;
        $this->status = $movement->inventory->status;
    }

    public function render()
    {
        return view('livewire.inventory.check-transfer')
            ->extends('layouts.bt4.app');
    }

    public function rules()
    {
        return (new CheckTransferRequest())->rules();
    }

    public function finish()
    {
        $dataValidated = $this->validate();
        $inventory = $this->movement->inventory;

        $this->movement->update([
            'reception_confirmation' => true,
            'reception_date' => now(),
            'observations' => $dataValidated['observations'],
        ]);

        $inventory->update([
            'status' => $dataValidated['status'],
            'deliver_date' => $this->movement->created_at,
            'place_id' => $this->movement->place_id,
            'user_responsible_id' => $this->movement->user_responsible_id,
            'user_using_id' => $this->movement->user_using_id,
        ]);

        session()->flash('success', 'El item del inventario fue recibido exitosamente.');
        return redirect()->route('inventories.assigned-products');
    }
}

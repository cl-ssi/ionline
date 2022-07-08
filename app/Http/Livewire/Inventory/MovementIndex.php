<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;

class MovementIndex extends Component
{
    public $inventory;

    protected $listeners = ['movementUpdated' => 'onMovementUpdated'];

    public function render()
    {
        return view('livewire.inventory.movement-index');
    }

    public function onMovementUpdated()
    {
        $this->render();
    }
}

<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;

class MovementIndex extends Component
{
    public $inventory;

    public $data_preview;

    protected $listeners = [
        'updateMovementIndex' => 'onUpdateMovementIndex',
        'updateDataPreview'
    ];

    public function render()
    {
        return view('livewire.inventory.movement-index');
    }

    public function onUpdateMovementIndex()
    {
        $this->render();
    }

    public function updateDataPreview($data_preview)
    {
        $this->data_preview = $data_preview;
    }
}

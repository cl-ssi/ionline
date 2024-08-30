<?php

namespace App\Livewire\Inventory;

use Livewire\Attributes\On; 
use Livewire\Component;

class MovementIndex extends Component
{
    public $inventory;

    public $data_preview;

    public function render()
    {
        return view('livewire.inventory.movement-index');
    }

    #[On('updateMovementIndex')] 
    public function onUpdateMovementIndex()
    {
        $this->render();
    }

    #[On('updateDataPreview')] 
    public function updateDataPreview($data_preview)
    {
        $this->data_preview = $data_preview;
    }
}

<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class Fusion extends Component
{
    public $input_item_a = '5380';
    public $input_item_b = '4883';

    public $item_a;
    public $item_b;
    public $fusion;

    protected $rules = [
        'input_item_a' => 'required',
        'input_item_b' => 'required',
    ];

    /**
     * Buscar Inventarios
     */
    public function search()
    {
        $this->validate();
        $item_a = Inventory::find($this->input_item_a);
        $item_b = Inventory::find($this->input_item_b);

        if (!$item_a) {
            $this->addError('input_item_a', 'El id no se encontró en la base de datos.');
        } else {
            $this->item_a = $item_a;
        }

        if (!$item_b) {
            $this->addError('input_item_a', 'El id no se encontró en la base de datos.');
        } else {
            $this->item_b = $item_b;
        }

    }
    
    /**
     * Fusion
     */
    public function fusion()
    {
        $this->validate([
            'fusion.old_number' => 'required',
        ]);
        app('debugbar')->log($this->fusion);
    }

    public function render()
    {
        return view('livewire.inventory.fusion');
    }
}

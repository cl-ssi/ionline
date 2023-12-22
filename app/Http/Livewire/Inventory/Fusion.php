<?php

namespace App\Http\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Inventory;

class Fusion extends Component
{
    public $input_origin = '5380';
    public $input_target = '4883';

    public $origin;
    public $target;

    protected $rules = [
        'input_origin' => 'required',
        'input_target' => 'required',
    ];

    /**
     * Buscar Inventarios
     */
    public function search()
    {
        $this->validate();
        $origin = Inventory::find($this->input_origin);
        $target = Inventory::find($this->input_target);

        if (!$origin) {
            $this->addError('input_origin', 'El id no se encontró en la base de datos.');
        } else {
            $this->origin = $origin;
        }

        if (!$target) {
            $this->addError('input_origin', 'El id no se encontró en la base de datos.');
        } else {
            $this->target = $target;
        }

        app('debugbar')->log($this->origin);
    }

    public function render()
    {
        return view('livewire.inventory.fusion');
    }
}

<?php

namespace App\Http\Livewire\Items;

use Livewire\Component;
use App\RequestForms\RequestForm;

class Item extends Component
{

    public $valor1;
    public $valor2;
    public $suma;

    public function mount()
    {
        $this->suma = 0;
    }

    private function suma()
    {
        $this->suma = $this->valor1 + $this->valor2;
    }

    public function render()
    {
        $this->suma();
        return view('livewire.items.item');
    }
}

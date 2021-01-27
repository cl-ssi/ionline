<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;

class AddSignature extends Component
{
    public $organizationalUnits, $visators;
    public $inputs = [];
    public $i = 1;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $this->organizationalUnits = OrganizationalUnit::where('establishment_id',38)->orderBy('id','asc')->get();
        return view('livewire.add-signature');
    }
}

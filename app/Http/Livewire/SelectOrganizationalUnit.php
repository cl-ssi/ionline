<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;

class SelectOrganizationalUnit extends Component
{
    public $ouRoots;

    public function render()
    {
        $this->ouRoots = OrganizationalUnit::where('level',1)->get();
        return view('livewire.select-organizational-unit');
    }
}

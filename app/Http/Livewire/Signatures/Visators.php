<?php

namespace App\Http\Livewire\Signatures;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;
use App\User;

class Visators extends Component
{
    public $organizationalUnit;
    public $users=[];
    public $ouUsers;
    public $inputs = [];
    public $i = 0;
    public $user;

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        foreach($this->inputs as $key => $value) {
            if(!empty($this->organizationalUnit[$value])) {
                $this->users[$value] = OrganizationalUnit::find($this->organizationalUnit[$value])->users;
            }
        }

        return view('livewire.signatures.visators')
        ->withOuRoots(OrganizationalUnit::where('level', 1)->where('establishment_id', 38)->get());
    }
}

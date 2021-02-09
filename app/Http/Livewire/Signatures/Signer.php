<?php

namespace App\Http\Livewire\Signatures;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;
use App\User;

class Signer extends Component
{
    public $organizationalUnit;
    public $users=[];
    public $user;

    public function render()
    {
        if(!empty($this->organizationalUnit)) {
            $this->users = OrganizationalUnit::find($this->organizationalUnit)->users;
        }
        return view('livewire.signatures.signer')
            ->withOuRoots(OrganizationalUnit::where('level', 1)->where('establishment_id', 38)->get());
    }
}

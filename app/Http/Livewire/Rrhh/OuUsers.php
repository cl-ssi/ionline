<?php

namespace App\Http\Livewire\Rrhh;

use App\Rrhh\OrganizationalUnit;
use Livewire\Component;

class OuUsers extends Component
{
    public $users = [];
    public $authority_id = null;
    public $listeners = ["getOuId" => "getUsersFromOu"];
    public $required = true;

    public function render()
    {
        return view('livewire.rrhh.ou-users');
    }

    public function getUsersFromOu(OrganizationalUnit $ou)
    {
        $this->users = $ou->users;
        $this->authority_id = $ou->currentManager->user_id ?? null;
    }
}

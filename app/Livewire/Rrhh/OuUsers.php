<?php

namespace App\Livewire\Rrhh;

use App\Models\Rrhh\OrganizationalUnit;
use Livewire\Attributes\On;
use Livewire\Component;

class OuUsers extends Component
{
    public $users = [];
    public $authority_id = null;
    public $required = true;
    public $ou_id = null;

    public function mount()
    {
        $this->getUsersFromOu($this->ou_id);
    }

    public function render()
    {
        return view('livewire.rrhh.ou-users');
    }

    #[On('getOuId')]
    public function getUsersFromOu($organizationalUnitId = null)
    {
        if(isset($organizationalUnitId) && $organizationalUnitId != '') {
            $ou = OrganizationalUnit::find($organizationalUnitId);
            $this->users = $ou->users;
            $this->authority_id = $ou->currentManager->user_id ?? null;
        } else {
            $this->users = collect();
            $this->authority_id = null;
        }
    }
}

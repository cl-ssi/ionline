<?php

namespace App\Http\Livewire\Sign;

use App\Models\Establishment;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Livewire\Component;

class AddSigner extends Component
{
    public $eventName;
    public $establishments;
    public $ous;
    public $users;

    public $search_organizational_unit;
    public $establishment_id;
    public $organizational_unit_id;
    public $user_id;

    public $organizationalUnit;

    public function mount()
    {
        $this->establishments = Establishment::all();
        $this->ous = [];
        $this->users = collect();
    }
    public function render()
    {
        return view('livewire.sign.add-signer');
    }

    public function updatedEstablishmentId($establishment_id)
    {
        if($establishment_id != '')
        {
            $this->ous = Establishment::find($establishment_id)->ouTreeWithAlias;
        }
        else
        {
            $this->ous = [];
        }

        $this->users = collect([]);
        $this->organizational_unit_id = null;
        $this->user_id = null;
    }

    public function updatedOrganizationalUnitId($organizational_unit_id)
    {
        if($organizational_unit_id != '')
        {
            $this->organizationalUnit = OrganizationalUnit::find($organizational_unit_id);

            if(isset($this->organizationalUnit->currentManager) && isset($this->organizationalUnit->currentManager->user))
            {
                $this->user_id = $this->organizationalUnit->currentManager->user->id;
            }
            else
            {
                $this->user_id = null;
            }

            $this->users = User::query()
                ->whereOrganizationalUnitId($organizational_unit_id)
                ->get();
        }
        else
        {
            $this->users = collect([]);
            $this->user_id = null;
        }

    }

    public function updatedSearchOrganizationalUnit($search)
    {
        $ous = collect($this->ous);

        if($search != '')
        {
            $this->ous = $ous->filter(function($ou) use ($search) {
                return stripos($ou , $search) !== false;
            });
        }
        else
        {
            if(isset($this->establishment_id))
            {
                $this->ous = Establishment::find($this->establishment_id)->ouTreeWithAlias;
            }
        }
    }

    public function add()
    {
        if($this->user_id != '')
        {
            $this->emit($this->eventName, $this->user_id);
            $this->users = collect([]);
            $this->ous = [];
            $this->establishment_id = '';
            $this->organizational_unit_id = null;
            $this->user_id = null;
        }
    }
}
